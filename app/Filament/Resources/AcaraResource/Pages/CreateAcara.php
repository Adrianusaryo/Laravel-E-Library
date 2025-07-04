<?php

namespace App\Filament\Resources\AcaraResource\Pages;

use App\Filament\Resources\AcaraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcara extends CreateRecord
{
    protected static string $resource = AcaraResource::class;
    protected static ?string $title = 'Tambah Acara';
    protected static ?string $breadcrumb = 'Tambah Acara';
}
