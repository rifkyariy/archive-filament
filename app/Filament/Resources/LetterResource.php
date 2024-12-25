<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterResource\Pages;
use App\Models\Letter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;


class LetterResource extends Resource
{
    protected static ?string $model = Letter::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Surat Masuk';
    protected static ?string $pluraLabel = 'Surat';
    protected static ?string $singularLabel = 'Surat';



    // Dynamically set the title for the page
    public static function getTitle(): string
    {

        return 'Surat Masuk';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('letter_code')
                    ->label('Nomor Surat')
                    ->placeholder('Contoh: 416/XYZ/12/2024')
                    ->required()
                    ->rule(function ($record) {
                        return Rule::unique('letters', 'letter_code')->ignore($record?->id);
                    })
                    ->disabled(fn($record) => $record !== null), // Disable for edit

                Forms\Components\TextInput::make('letter_source_instance')
                    ->label('Asal Instansi')
                    ->placeholder('Contoh: Dinas Kesehatan')
                    ->required(),

                Forms\Components\DatePicker::make('letter_date')
                    ->label('Tanggal Surat')
                    ->default(now())
                    ->required(),

                Forms\Components\TextInput::make('letter_recipient')
                    ->label('Penerima')
                    ->placeholder('Contoh: Kepala Desa')
                    ->required(),

                Forms\Components\Textarea::make('letter_description')
                    ->label('Deskripsi Singkat')
                    ->required(),

                Forms\Components\DatePicker::make('letter_forward_date')
                    ->label('Tanggal Diteruskan (Opsional)'),

                Forms\Components\FileUpload::make('letter_file_pdf')
                    ->label('File PDF (Opsional)')
                    ->directory('letters')
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('letter_code')
                    ->label('Letter Code')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('letter_date')
                    ->label('Letter Date')
                    ->sortable()
                    ->date(),

                Tables\Columns\TextColumn::make('letter_source_instance')
                    ->label('Source Instance')
                    ->searchable(),

                Tables\Columns\TextColumn::make('letter_recipient')
                    ->label('Recipient')
                    ->searchable(),

                Tables\Columns\TextColumn::make('letter_description')
                    ->label('Description')
                    ->limit(50),

                // Add a download button with an icon for the PDF file
                Tables\Columns\TextColumn::make('letter_file_pdf')
                    ->label('PDF File')
                    ->url(fn($record) => $record->letter_file_pdf ? asset('storage/' . $record->letter_file_pdf) : null)
                    ->openUrlInNewTab()
                    ->getStateUsing(fn($record) => $record->letter_file_pdf ? 'Download' : 'No File'), // Add custom view for the button
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->emptyStateIcon('heroicon-o-inbox')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambah Surat Baru')
                    ->url(static::getUrl('create')) // Dynamically generates the create URL
                    ->icon('heroicon-o-plus-circle') // Changed icon for better clarity
                    ->button(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('letter_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetters::route('/'),
            'create' => Pages\CreateLetter::route('/create'),
            'edit' => Pages\EditLetter::route('/{record}/edit'),
        ];
    }
}
