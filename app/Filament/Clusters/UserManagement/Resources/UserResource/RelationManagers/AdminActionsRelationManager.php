<?php 

declare(strict_types=1); 

namespace App\Filament\Clusters\UserManagement\Resources\UserResource\RelationManagers;

use BackedEnum;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AdminActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'adminActions'; 

    protected static ?string $title = 'Administratie logboek';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedQueueList; 

    public function table(Table $table): Table 
    {
        return $table
            ->heading('Administratief logboek')
            ->description('Een overzicht van alle gelogde geregistreerde administratieve acties die door een administrator zijn ondernomen.')
            ->emptyStateIcon(Heroicon::OutlinedQueueList)
            ->emptyStateHeading('Geen handelingen gevonden')
            ->emptyStateDescription('Er zijn momenteel geen gelogde handelingen gevonden die betrekking hebben tot dit gebruikersprofiel.')
            ->headerActions(actions: $this->registerHeaderActions())
            ->columns(components: $this->registerTableColumns());
    }

    private function registerHeaderActions(): array 
    {
        return [];
    }

    private function registerTableColumns(): array 
    {
        return [
            TextColumn::make('causer.name')
        ];
    }
}