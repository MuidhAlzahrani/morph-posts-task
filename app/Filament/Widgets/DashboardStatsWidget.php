<?php

namespace App\Filament\Widgets;

use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count()),
            Stat::make('Posts', Post::count()),
            Stat::make('Comments', Comments::count()),
        ];
    }
}
