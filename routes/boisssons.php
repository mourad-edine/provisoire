<?php

use App\Http\Controllers\acceil\AccueilController;
use App\Http\Controllers\achat\AchatController;
use App\Http\Controllers\article\ArticleController;
use App\Http\Controllers\caregorie\CategorieController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\commande\CommandeController;
use App\Http\Controllers\consignation\ConsignationController;
use App\Http\Controllers\depense\DepenseController;
use App\Http\Controllers\fournisseur\FournisseurController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\stat\StatController;
use App\Http\Controllers\stock\StockController;
use App\Http\Controllers\vente\VenteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('boissons')->group(function () {
    Route::get('/dashboard', [AccueilController::class, 'dash'])->name('page.accueil');

    Route::get('/categories', [CategorieController::class, 'show'])->name('categorie.liste');
    Route::post('/categories', [CategorieController::class, 'store'])->name('categorie.store');
    Route::post('/categories-update', [CategorieController::class, 'update'])->name('categorie.update');
    Route::get('/categories/{id}', [CategorieController::class, 'delete'])->name('delete.categorie');

    Route::post('/articles-update', [ArticleController::class, 'update'])->name('articles.update');
    Route::get('/articles', [ArticleController::class, 'show'])->name('article.liste');
    // Route::get('/articles/search', [ArticleController::class, 'show'])->name('articles.search');

    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/search', [ArticleController::class, 'show'])->name('articles.search');

    Route::get('/articles/{id}', [ArticleController::class, 'delete'])->name('delete.article');


    Route::get('/ventes', [VenteController::class, 'show'])->name('vente.liste');
    Route::get('/ventes-rendu/{id}', [VenteController::class, 'rendu'])->name('vente.rendu');

    Route::post('/ventes', [VenteController::class, 'store'])->name('vente.store');

    Route::get('/commandes-vente', [VenteController::class, 'showcommande'])->name('commande.liste.vente');
    Route::get('/commandes-vente-detail/{id}', [VenteController::class, 'DetailCommande'])->name('commande.liste.vente.detail');
    Route::get('/ventes-page', [VenteController::class, 'Vente'])->name('vente.page');
    Route::get('/rendre/{id}', [VenteController::class, 'Rendre'])->name('rendre.boissons');
    Route::get('/payement/{id}', [VenteController::class, 'Paiment'])->name('paiment.boissons');
    Route::get('/payement-all', [VenteController::class, 'PaimentAll'])->name('paiment.all');

    Route::post('/rendre', [VenteController::class, 'RendreStore'])->name('rendre.store');

    Route::post('/regeler-payement', [VenteController::class, 'regler'])->name('regler.payement');



    Route::get('/achats', [AchatController::class, 'show'])->name('achat.liste');
    Route::get('/achats-page', [AchatController::class, 'showachat'])->name('achat.page');

    Route::get('/commande-achats', [AchatController::class, 'commande'])->name('achat.commande');
    Route::get('/commande-achats/{id}', [AchatController::class, 'detailcommande'])->name('achat.commande.detail');
    Route::post('/achats', [AchatController::class, 'store'])->name('achat.store');

    Route::get('/commandes', [CommandeController::class, 'show'])->name('commande.liste');

    // Route::get('/ventes', [VenteController::class, 'show'])->name('vente.liste');
    Route::post('/rendre_rendu', [ConsignationController::class, 'rendrerendu'])->name('rendre.rendu');

    Route::get('/clients', [ClientController::class, 'show'])->name('client.liste');
    Route::get('/clients-performance', [ClientController::class, 'performance'])->name('client.performance');
    Route::get('/clients-historique/{id}', [ClientController::class, 'historique'])->name('client.historique');

    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
    Route::get('/clients-profil/{id}', [ClientController::class, 'profil'])->name('client.profil');

    Route::get('/clients/{id}', [ClientController::class, 'delete'])->name('delete.client');
    Route::get('/clients-commande/{id}', [ClientController::class, 'showCommande'])->name('client.commande');

    Route::get('/fournisseurs', [FournisseurController::class, 'show'])->name('fournisseur.liste');
    Route::get('/fournisseurs-performance', [FournisseurController::class, 'performance'])->name('fournisseur.performance');
    Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('fournisseur.store');
    Route::get('/fournisseurs/{id}', [FournisseurController::class, 'delete'])->name('delete.fournisseur');


    Route::get('/stock-categorie', [StockController::class, 'categorie'])->name('stock.categorie.liste');
    Route::get('/stock-globale', [StockController::class, 'show'])->name('stock.liste');
    Route::get('/stock-faible', [StockController::class, 'faible'])->name('stock.faible.liste');
    Route::get('/stock-by-id/{id}', [StockController::class, 'stockbyCategorie'])->name('stock.liste.id');
    Route::get('/statistique', [StatController::class, 'show'])->name('stat');
    Route::get('/depense', [AchatController::class, 'depense'])->name('depense');
    Route::post('/depense_store', [DepenseController::class, 'store'])->name('depense.store');
    Route::delete('/depense_delete/{id}', [DepenseController::class, 'destroy'])->name('depense.destroy');


    Route::get('/download-pdf/{id}', [PdfController::class, 'generatePDF'])->name('pdf.download');
    Route::get('/download-pdf-achat/{id}', [PdfController::class, 'achatpdf'])->name('pdf.achat');

    Route::post('/consignation-payer', [ConsignationController::class, 'payer'])->name('payer.consignation');
    Route::post('/consignation-payer-achats', [ConsignationController::class, 'payerAchat'])->name('payer.consignation.achat');
    Route::post('/consignation-payer-condi', [ConsignationController::class, 'rendrecondi'])->name('payer.condi');

    Route::get('/parametre-boissons', [ConsignationController::class, 'parametre'])->name('parametre');
    Route::post('/parametre-boissons', [ConsignationController::class, 'prix'])->name('parametre.store');

    Route::post('/parametre-user', [ConsignationController::class, 'adduser'])->name('add.user');
});