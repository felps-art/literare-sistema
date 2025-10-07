# Literare – Roadmap de Evolução Social

Este documento descreve funcionalidades planejadas para tornar o Literare uma rede social de leitura rica, escalável e engajante. Ele está organizado por categorias, com ondas (waves) sugeridas de implementação.

## Visão Geral
Criar uma experiência social centrada em leitura, descoberta, interação e construção de reputação, preservando simplicidade inicial e espaço para expansão.

---
## 1. Núcleo Social (Social Graph)
- ✅ Seguir / deixar de seguir usuários (`follows`) — implementado com controller, rotas e testes (idempotência, self-block, unfollow)
- ✅ Feed personalizado (resenhas, posts, progresso de leitura) — unificado via `activities` (post_created, resenha_created, reading_progress_created/updated) com paginação por cursor e suporte JSON
	- ⏳ Compartilhamentos ainda não implementados (adiado conforme decisão)
- ⏳ Notificações internas (likes, follows, menções, comentários, badges)
- ⏳ Menções (@usuario) → gera notificação
- ⏳ Hashtags / tags temáticas com página agregadora

## 2. Conteúdo e Engajamento
- Reações múltiplas (👍 ❤️ 🤯 😢 📚)
- Comentários encadeados (parent_id)
- Salvar / favoritar itens (`saved_items`)
- Compartilhar / republicar conteúdo (`shares`)
- Rascunhos de resenhas (`is_draft`)
- Spoilers com marcação `[spoiler]...[/spoiler]`
- Sistema de pontos e badges (gamificação)
- Ranking semanal de resenhas (score: engajamento)

## 3. Descoberta e Recomendação
- Busca avançada (Scout / índice por título, autor, tags)
- Recomendações heurísticas (similaridade de leituras)
- Sugestões de usuários para seguir
- Trending (livros, autores, tags) por janela temporal
- Página Explorar (explore) com agregados

## 4. Perfil e Identidade
- Bio rica + links externos
- Banner/capa de perfil
- Estatísticas públicas (livros lidos no ano, páginas, média)
- Conta privada (aprovação de seguidores) + `follow_requests`
- Bloqueio / silenciamento (`user_blocks`)
- Prateleiras personalizadas (shelves + shelf_items)

## 5. Leitura e Progresso
- Tracking granular de progresso (percentual ou página)
- Desafios de leitura anuais (reading_challenges)
- Eventos de progresso no feed (com rate limit)

## 6. Moderação e Segurança
- Denúncia de conteúdo (`reports`)
- Filtro de linguagem ofensiva (pré ou pós moderação)
- Rate limiting por tipo de ação
- Auditoria de ações (audit_logs)
- Suspensão temporária (`suspended_until`)
- Fila de revisão (flag `needs_review`)

## 7. Notificações e Tempo Real
- WebSockets (Echo + Pusher/Soketi) para eventos ao vivo
- Notificações em tempo real (curtidas, menções, follow)
- E-mail digest semanal
- Push notifications (PWA + subscriptions)

## 8. UX / UI
- Infinite scroll em feed e listas
- Skeleton loading / placeholders
- Hover cards (pré-visualização de perfil)
- Editor de resenha com preview markdown
- Modo escuro (persistência)
- Acessibilidade (ARIA, contraste, navegação teclado)

## 9. Performance & Escalabilidade
- Cache de contadores (likes, comments)
- Eager loading estratégico + `withCount`
- Jobs assíncronos para feed, rankings, digest
- Redis (cache, fila, rate limit)
- Paginação por cursor para feed
- Índices críticos (user_id+created_at, taggable, follow relations)

## 10. Observabilidade e Qualidade
- Logging estruturado (JSON) de eventos-chave
- Métricas (Prometheus / Horizon) – throughput e latências
- Feature flags para lançamentos graduais
- Testes de políticas, feed ordering, notificações
- Seeders ricos para ambiente demo

## 11. Monetização / Futuro (Opcional)
- Plano premium (estatísticas avançadas, sem ads)
- Conteúdo patrocinado sinalizado
- Autores verificados (badge)
- Exportação de dados (LGPD) /backup
- API pública versionada

---
## Ondas (Waves) de Implementação

### Wave 1 (MVP Social)
Status atual:
- ✅ Seguimento/follow
- ✅ Feed básico (posts, resenhas, progresso de leitura) — faltam: compartilhamentos, notificações, menções, comentários encadeados
- Próximos alvos recomendados: menções, notificações mínimas (follow/like), comentários encadeados

### Wave 2 (Engajamento & Descoberta)
Hashtags, salvar item, reações múltiplas, trending simples, recomendações heurísticas iniciais.

### Wave 3 (Gamificação & Retenção)
Sistema de pontos, badges, ranking semanal, desafios de leitura.

### Wave 4 (Moderação & Escala)
Denúncias, bloqueios, rate limits, caching de contadores, jobs de feed.

### Wave 5 (Tempo Real & Premium)
WebSockets, digest semanal, PWA push, exportação de dados.

---
## Estruturas de Tabelas (Esboços)

### follows
```
(id, follower_id FK users, followed_id FK users, created_at)
UNIQUE(follower_id, followed_id)
```

### reactions
```
(id, user_id FK users, reactable_type, reactable_id, type, created_at)
UNIQUE(user_id, reactable_type, reactable_id, type)
```

### mentions
```
(id, mentioner_id FK users, mentioned_id FK users, mentionable_type, mentionable_id, created_at)
```

### saved_items
```
(id, user_id FK users, saveable_type, saveable_id, created_at)
UNIQUE(user_id, saveable_type, saveable_id)
```

### shares
```
(id, user_id FK users, shareable_type, shareable_id, comment nullable, created_at)
```

### reports
```
(id, reporter_id FK users, target_type, target_id, reason, status enum[pending,accepted,rejected], created_at)
```

### audit_logs
```
(id, user_id FK users nullable, action, object_type, object_id, meta json, created_at)
```

### reading_progress
```
(id, user_id FK users, livro_id FK livros, pages_total int, page_current int, percent computed/virtual, updated_at)
UNIQUE(user_id, livro_id)
```

---
## Considerações Técnicas
- Usar Policies para controle de ações (seguir privado, bloquear, denunciar)
- Observer ou Events para disparar notificações (Liked, Followed, Mentioned)
- Jobs para ranking e digest semanal
- DTOs/Resources para padronizar payloads
- Cache (Redis) para agregações de feed e trending
- Sanitização de HTML/Markdown (evitar XSS)

## Próximos Passos Imediatos (Sugestão)
1. Implementar compartilhamentos (`shares`) integrados ao feed (activity: share_created)
2. Adicionar notificações iniciais (follow_created, like_post, like_resenha)
3. Menções (@usuario) com parser simples e activity + notificação
4. Comentários encadeados (parent_id) e inclusão no feed se pertinente
5. Cache de contadores (followers_count, likes_count) + índices complementares (user_id, created_at) para otimizar feed

## Registro de Progresso
- [DATA] Feed básico entregue (posts, resenhas, progresso) sem compartilhamentos
- [DATA] Sistema de follow concluído com testes automatizados

---
Se desejar, prossiga abrindo issues no GitHub dividindo cada bloco. Este documento pode ser expandido com prioridades numéricas e estimativas.
