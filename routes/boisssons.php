<?php

use App\Http\Controllers\acceil\AccueilController;
use App\Http\Controllers\achat\AchatController;
use App\Http\Controllers\article\ArticleController;
use App\Http\Controllers\caregorie\CategorieController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\commande\CommandeController;
use App\Http\Controllers\fournisseur\FournisseurController;
use App\Http\Controllers\stock\StockController;
use App\Http\Controllers\vente\VenteController;
use Illuminate\Support\Facades\Route;

Route::prefix('boissons')->group(function () {
    Route::get('/dashboard', [AccueilController::class, 'dash'])->name('page.accueil');

    Route::get('/categories', [CategorieController::class, 'show'])->name('categorie.liste');
    Route::post('/categories', [CategorieController::class, 'store'])->name('categorie.store');

    Route::get('/articles', [ArticleController::class, 'show'])->name('article.liste');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

    Route::get('/ventes', [VenteController::class, 'show'])->name('vente.liste');
    Route::post('/ventes', [VenteController::class, 'store'])->name('vente.store');

    Route::get('/achats', [AchatController::class, 'show'])->name('achat.liste');
    Route::post('/achats', [AchatController::class, 'store'])->name('achat.store');

    Route::get('/commandes', [CommandeController::class, 'show'])->name('commande.liste');

    Route::get('/ventes', [VenteController::class, 'show'])->name('vente.liste');

    Route::get('/clients', [ClientController::class, 'show'])->name('client.liste');
    Route::get('/clients-performance', [ClientController::class, 'performance'])->name('client.performance');
    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');

    Route::get('/fournisseurs', [FournisseurController::class, 'show'])->name('fournisseur.liste');
    Route::get('/fournisseurs-performance', [FournisseurController::class, 'performance'])->name('fournisseur.performance');
    Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('fournisseur.store');

    Route::get('/stock-categorie', [StockController::class, 'categorie'])->name('stock.categorie.liste');
    Route::get('/stock-globale', [StockController::class, 'show'])->name('stock.liste');
    Route::get('/stock-faible', [StockController::class, 'faible'])->name('stock.faible.liste');
    Route::get('/stock-by-id/{id}', [StockController::class, 'stockbyCategorie'])->name('stock.liste.id');

});