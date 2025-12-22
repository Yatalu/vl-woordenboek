<?php 

declare(strict_types=1); 

namespace App\Filament\Clusters\UserManagement\Resources\UserResource\RelationManagers;

use App\Features\DocumentationButtons;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\AdminActionLog;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Laravel\Pennant\Feature;

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
            ->recordActions(actions: $this->registerRecordActions())
            ->columns(components: $this->registerTableColumns());
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return new $pageClass() instanceof ViewUser;
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components(components: [
            Fieldset::make('Handeling')
                ->columns(12)
                ->columnSpanFull()
                ->schema(components: []),

            Fieldset::make('Uitgevoerd door')
                ->columns(12)
                ->columnSpanFull()
                ->schema(components: []),
        ]);
    }

    private function registerHeaderActions(): array 
    {
        return [
            Action::make('Help')
                ->icon(Heroicon::OutlinedLifebuoy)
                ->color('primary')
                ->visible(Feature::active(DocumentationButtons::class))
                ->url('https://www.google.com', shouldOpenInNewTab: true)
        ];
    }

    private function registerRecordActions(): array 
    {
        return [
            ViewAction::make()
                ->modalHeading(fn (AdminActionLog $adminActionLog): string => "#{$adminActionLog->id} - {$adminActionLog->action}")
                ->modalIcon(Heroicon::OutlinedInformationCircle)
                ->modalIconColor('primary')
                ->modalCloseButton(false)
                ->modalDescription('Informatie omtrent een handeling die een administor heeft uitgevoerd met betrekking op het account.')
        ];
    }

    private function registerTableColumns(): array 
    {
        return [
            TextColumn::make('causer.name')
                ->icon(Heroicon::OutlinedUserCircle)
                ->iconColor('primary')
                ->label('Uitgevoerd door'), 
            TextColumn::make('ip_address')
                ->icon(Heroicon::OutlinedGlobeEuropeAfrica)
                ->label('IP adres'),
            TextColumn::make('action')
                ->label('Handeling')
                ->badge()
                ->icon(Heroicon::OutlinedTag)
                ->searchable()
                ->sortable(), 
            TextColumn::make('description')
                ->label('Beschrijving')
                ->searchable(),
            TextColumn::make('created_at')
                ->label('Uitgevoerd op')
                ->date()
                ->sinceTooltip()
                ->sortable(),
        ];
    }
}