# Melhorias, Unificações e Novas Funções Sociais

Este documento consolida sugestões de arquitetura, UX e recursos sociais para evoluir o Literare. Foca em reduzir duplicação, padronizar comportamento (curtidas), melhorar desempenho/observabilidade e aumentar engajamento.

## 1) Unificar curtidas (Like) em base polimórfica

- Tabela única `likes`: `id, user_id, likeable_id, likeable_type, timestamps`, índice único `(user_id, likeable_id, likeable_type)`.
- Modelos (`Post`, `Resenha`, `Comment`, `ResenhaComment`) passam a usar `morphMany(Like::class, 'likeable')`.
- Benefícios: menos controllers, menos migrations, DRY, queries genéricas e facilidades para relatórios.

### Trait Likable
- Crie um trait reutilizável com:
  - `likes()` (relação polimórfica)
  - `isLikedBy(User $user): bool`
  - `likesCount(): int`
  - `toggleLike(User $user): array { liked: bool, count: int }` (opcional)
- Aplique a todo modelo “curtível”.

### LikeService
- Serviço de negócio que centraliza attach/detach, contadores, eventos, rate-limit.
- Assinatura sugerida: `toggle(User $user, Model $likeable): array { liked: bool, count: int }`.
- Permite um único controller genérico e regras consistentes.

### Controller genérico de like
- Endpoint pode receber `{type, id}` ou rotas nomeadas polimórficas (ex.: `/like/{type}/{id}`), sempre retornando JSON padronizado.

### Contadores e concorrência
- Preferir `withCount()` em listagens; se usar coluna `likes_count` como cache, atualizar em transação e tratar idempotência (unique composto evita duplicatas).

### Índices/FKs e autorização
- Índices em FKs de todas as tabelas e unique em pivots.
- Likes não requerem Policy; comentários/remoção sim (já existente).
- Throttle nas rotas de like (ex.: `30/min` por usuário) para evitar spam.

---

## 2) Melhorias de Frontend (UX/UI)

- Componente Blade `<x-like-button>`
  - Props: `type`, `id`, `liked`, `count`, `size`.
  - Padroniza ícone, classes, datasets e acessibilidade.
- Acessibilidade
  - `aria-pressed`, `aria-label` dinâmicos, foco visível.
- Estado otimista + rollback
  - Atualiza ícone/contador imediatamente; reverte se a request falhar.
- Live updates
  - Laravel Echo/WebSockets para atualizar contadores em tempo real quando outros curtirem.
- Formulários (ex.: Livros)
  - Autores com busca (tom-select/select2) + múltipla seleção.
  - Validação visual (Bootstrap `is-invalid`), placeholders e dicas (já iniciado em livros/create).

---

## 3) Novas funções sociais

- Reações (além de curtir)
  - Tipos (amei/aplaudi/curioso/etc.) via `reaction_type` na mesma tabela ou nova `reactions`.
  - UI com popover no clique longo.
- Notificações
  - Curtiram/comentaram/seguiram você → Notifications (canal `database`).
  - Sininho com não lidas e página de notificações.
- Comentários avançados
  - Respostas (threads), citar, menções `@usuario` com autocompletar e notificação.
  - Hashtags e páginas de hashtag.
- Conteúdo salvo
  - “Salvar” posts/resenhas em coleções (bookmarks). Listas públicas/privadas.
- Seguir entidades
  - Seguir autores e editoras; feed inclui atividade relacionada.
- Descoberta/Trends
  - Populares nas últimas 24h/semana, por gênero/autor. Recomendações personalizadas.
- Gamificação
  - Pontos por publicar, receber curtidas, comentar. Badges de marcos.
- Moderação/relatórios
  - Report de conteúdo/comentário; fila de moderação. Filtro de termos.
- Privacidade
  - Níveis: público/seguidores/apenas eu. Bloquear/mutar usuários.

---

## 4) Performance e Observabilidade

- Eager loading + `withCount` em feeds para evitar N+1 (trazer likes/comments count de uma vez) e flag "liked by me" por subselect.
- Cache leve (30–60s) de contadores em páginas quentes; invalidar em like/unlike.
- Telemetria
  - Logs de eventos (like/comment/follow), métricas (por hora/dia), painéis com Telescope/Horizon.

---

## 5) Testes recomendados

- Rotas JSON de like/unlike para todos os tipos (post, resenha, comentário, comentário de resenha):
  - Fluxo feliz + idempotência (segundo clique não duplica).
  - Sem autenticação: 302/401 conforme regra.
  - Unique/concorrência: não deve quebrar a resposta da UI.
- Feed/Explore: componentes exibem `liked` e contagem correta.

---

## 6) i18n e SEO

- Internacionalização (Blade strings → lang files), facilitar PT/EN.
- OpenGraph/Twitter cards em páginas públicas (resenhas/livros) para compartilhamento.

---

## 7) Segurança

- Sanitização/escape de conteúdo em comentários/resenhas (manter `e()`/whitelist se for HTML).
- Uploads: validar tipo/tamanho; gerar thumbs otimizadas (Intervention Image/Spatie Media Library).

---

## 8) Roadmap priorizado (sugestão)

1. Unificar lógica de likes com Trait `Likable` + `LikeService` (sem mudar schema ainda).
2. Criar componente Blade de botão de like e aplicar nas telas (feed, índices, show, comentários).
3. Notificações básicas (curtiu/comentou/seguiu) com canal `database`.
4. Seguir autores/editoras e páginas de hashtag (descoberta).
5. Reações múltiplas e menções `@` (engajamento avançado).
6. Migrar para tabela polimórfica de `likes`+ migração de dados (separadamente e com plano de rollback).

---

## 9) Quick wins (baixo risco, alto impacto)

- Trait `Likable` + `LikeService` agora.
- Componente Blade `<x-like-button>` para padronizar UI.
- Throttle nas rotas de like/unlike.
- `withCount()` + subselect “liked_by_me” nas listagens principais.

---

## Rascunho de migração polimórfica (futuro)

- Nova tabela `likes_polymorphic`; copiar dados das tabelas atuais preenchendo `likeable_type`/`likeable_id`.
- Ajustar modelos para `morphMany` e rotas para controller genérico.
- Congelar escrita nas antigas (flag de feature), migrar tráfego, validar, então remover antigas.
