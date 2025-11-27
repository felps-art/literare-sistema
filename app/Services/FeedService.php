<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class FeedService
{
    /**
     * Busca atividades para o feed personalizado.
     * Somente tipos de criação de conteúdo principal: post_created, resenha_created.
     * @param User|null $user
     * @param int $limit
     * @param int|null $cursor id da activity para cursor pagination (infinite scroll)
     * @return array{items: Collection, nextCursor: int|null}
     */
    public function fetch(?User $user, int $limit = 25, ?int $cursor = null): array
    {
        $followIds = [];
        if ($user) {
            $followIds = $user->follows()->pluck('users.id')->toArray();
            $followIds[] = $user->id; // inclui o próprio
        }

        $types = [
            'post_created',
            'resenha_created',
        ];

        $query = Activity::with(['user','subject'])
            ->whereIn('type', $types)
            ->when(!empty($followIds), fn($q) => $q->whereIn('user_id', $followIds))
            ->orderByDesc('id');

        if ($cursor) {
            $query->where('id', '<', $cursor);
        }

        $activities = $query->limit($limit + 1)->get();
        $nextCursor = null;
        if ($activities->count() > $limit) {
            $nextCursor = $activities->slice($limit)->first()->id;
            $activities = $activities->take($limit);
        }

        return [
            'items' => $activities,
            'nextCursor' => $nextCursor,
        ];
    }
}
