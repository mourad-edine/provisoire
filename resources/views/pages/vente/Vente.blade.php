@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light border-bottom shadow-sm">
            <div class="d-flex">
                <a href="{{route('vente.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes ventes</a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <div class="d-flex">

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#venteModal2">Autre Modal</button>

            </div>
        </div>

    </div> -->
    <!-- Button trigger modal -->


    <!-- Modal Nouvelle vente -->
    <section id="venteSection ">
        <div class="card shadow mb-4 p-4">
            <form id="venteForm" method="POST" action="{{ route('vente.store') }}">
                @csrf
                <div class="row">
                    <!-- Première ligne : Clients et Numéro de commande -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client">Clients</label>
                            <select class="form-control select-search" id="client" name="client_id">
                                <option value="">--client passager--</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cm">Numéro commande</label>
                            <input type="text" value="C-{{ $dernier->id + 1}}" class="form-control" id="cm" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Deuxième ligne : Article et Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="article">Article</label>
                            <select class="form-control select-search" id="article">
                                @foreach($articles as $article)
                                <option value="{{ $article->id }}" data-prix="{{ $article->prix_unitaire }}" data-condi="{{ $article->conditionnement }}" data-consignation="{{ $article->prix_consignation }}">{{ $article->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateachat">Date</label>
                            <input type="date" class="form-control" id="datevente" value="today" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Troisième ligne : Achat par unité ou cageot -->
                    <div class="col-md-6">
                        <div class="unitecontainer">
                            <div class="col-md-12 mb-3 d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="achatUnite">
                                    <label class="form-check-label" for="achatUnite">Achat par unité</label>
                                </div>
                                <div class="form-check cageotcontainer ml-3">
                                    <input class="form-check-input" type="checkbox" id="achatCageot" checked>
                                    <label class="form-check-label" for="achatCageot">Achat par cageot</label>
                                </div>
                            </div>
                            <div id="quantiteCageotContainer">
                                <div class="form-group">
                                    <label for="quantiteCageot">Quantité en cageot</label>
                                    <input type="number" class="form-control" id="quantiteCageot" min="1" value="1">
                                </div>
                            </div>
                            <div id="quantiteUniteContainer" style="display: none;">
                                <div class="form-group">
                                    <label for="quantiteUnite">Quantité en unité</label>
                                    <input type="number" class="form-control" id="quantiteUnite" min="1" value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- contenu -->
                    </div>
                    <div class="col-md-12 mb-3 d-flex justify-content-start">

                        <div class="form-check mr-3">
                            <input class="form-check-input" type="checkbox" id="avec">
                            <label class="form-check-label" for="avec">Avec bouteille</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cgt">
                            <label class="form-check-label" for="cgt">avec cageot</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 d-flex form-check ml-3">
                        <input class="form-check-input" type="checkbox" id="unite" name="unites">
                        <label class="form-check-label" for="unite">conditionner unité</label>
                    </div>
                </div>

                <button type="button" class="btn btn-success" id="ajouterArticle">Ajouter</button>

                <!-- Conteneur caché pour stocker les valeurs envoyées en POST -->
                <div id="hiddenInputs"></div>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>P.U</th>
                            <th>Prix consigné</th>
                            <th>Quantité</th>
                            <th>Cgt</th>
                            <th>BTL</th>
                            <th>état</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="articlesTable"></tbody>
                </table>
                <div class="form-footer d-flex justify-content-end">
                    <p id="final" class="mr-3">0</p>
                    <span class="mr-3">Ar</span>
                    <a id="final3"
                        style="display: none;"
                        class="btn btn-primary btn-sm p-2"
                        data-toggle="modal"
                        data-target="#venteModal2">
                        Valider
                    </a>
                    <button type="submit"

                        class="btn btn-primary"
                        id="final2">
                        Valider
                    </button>
                </div>

                <div class="modal fade" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="venteModal2Label">Nombre de cageot</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                                <label for="dateachat">Cageot de 24 : <span class="text-warning" id="c24">0</span></label> &nbsp;-----------&nbsp;<label for="dateachat">débordement : <span class="text-warning" id="reste1">0</span> &nbsp;BTL</label><input class="form-check-input" type="checkbox" id="choix1" name="choix1">

                                                <br>
                                                <label for="dateachat">Cageot de 20 : <span class="text-warning" id="c20">0</span></label> &nbsp;-----------&nbsp;<label for="dateachat">debordement : <span class="text-warning" id="reste2">0</span> &nbsp;BTL</label><input class="form-check-input" type="checkbox" id="choix1" name="choix2"><br>

                                            </div>


                                            <div class="form-group d-flex justify-content-start ">
                                                <p>total unité : <span></span></p> &nbsp;
                                                <p class="text-success" id="tot"> 0 </p>
                                            </div>
                                            <div class="col-md-12">
                                                <input class="form-check-input" type="checkbox" id="choix" name="choix">
                                                <label class="form-check-label" for="choix">choisir nombre cageot</label>
                                            </div>
                                            <div class="form-group" id="choix_content" style="display: none;">
                                                <input type="number" class="form-control" name="embale" id="embale" placeholder="entrez votre choix">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">annuler</button>

                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const achatUnite = document.getElementById("achatUnite");
        const achatCageot = document.getElementById("achatCageot");
        const quantiteCageotContainer = document.getElementById("quantiteCageotContainer");
        const quantiteUniteContainer = document.getElementById("quantiteUniteContainer");
        const non = document.getElementById('non');
        const avec = document.getElementById('avec');
        const final = document.getElementById('final');
        const final2 = document.getElementById('final2');
        const final3 = document.getElementById('final3');
        const tot = document.getElementById('tot');
        const c24 = document.getElementById('c24');
        const c20 = document.getElementById('c20');
        const reste1 = document.getElementById('reste1');
        const reste2 = document.getElementById('reste2');
        const choix_content = document.getElementById('choix_content');
        const choix = document.getElementById('choix');
        const embale = document.getElementById('embale');

        const uni = document.getElementById('unite'); // Assurez-vous que cet élément existe
        // Assurez-vous que cet élément existe

        const prix_cgt = 3000;
        const cgt_checkbox = document.getElementById('cgt');
        const unite = document.getElementById('unite');
        const vars = 1;

        function toggleDisplay() {
            if (achatUnite.checked) {
                quantiteUniteContainer.style.display = "block";
                quantiteCageotContainer.style.display = "none";
                achatCageot.checked = false;
                cgt_checkbox.checked = false;
                cgt_checkbox.disabled = true;
            } else {
                quantiteUniteContainer.style.display = "none";
                quantiteCageotContainer.style.display = "block";
                achatCageot.checked = true;
                cgt_checkbox.disabled = false;

            }
        }

        if (uni) {
            uni.addEventListener("change", function() {
                if (uni.checked) {
                    // Show final2 and hide final3
                    final2.style.display = 'none';
                    final3.style.display = 'block';
                } else {
                    // Hide final2 and show final3
                    final2.style.display = 'block';
                    final3.style.display = 'none';
                }
            });
        }
        if (choix) {
            choix.addEventListener("change", function() {
                if (choix.checked) {
                    choix_content.style.display = 'block';
                } else {
                    // Hide final2 and show final3
                    choix_content.style.display = 'none';
                }
            });
        }


        // if (avec) {
        //     avec.addEventListener("change", function() {
        //         if (!avec.checked && !non.checked) {
        //             avec.checked = false;
        //         }
        //     });
        // }

        if (achatUnite) achatUnite.addEventListener("change", toggleDisplay);
        if (achatCageot) {
            achatCageot.addEventListener("change", function() {
                achatUnite.checked = !achatCageot.checked;
                toggleDisplay();
            });
        }

        document.getElementById('datevente').value = new Date().toISOString().split('T')[0];
        let totalQuantiteUnite = 0;

        document.getElementById('ajouterArticle').addEventListener('click', function() {
            let articleSelect = document.getElementById('article');
            let datevente = document.getElementById('datevente').value;
            let selectedOption = articleSelect.options[articleSelect.selectedIndex];

            if (!selectedOption) {
                alert("Veuillez sélectionner un article.");
                return;
            }

            let articleId = selectedOption.value || "";
            let articleNom = selectedOption.text || "";
            let prix = parseInt(selectedOption.getAttribute('data-prix'), 10) || 0;
            let conditionnement = parseInt(selectedOption.getAttribute('data-condi'), 10) || 1;
            let prix_consignation = parseInt(selectedOption.getAttribute('data-consignation'), 10) || 0;

            let quantite = achatUnite.checked ?
                parseInt(document.getElementById('quantiteUnite').value, 10) || 0 :
                parseInt(document.getElementById('quantiteCageot').value, 10) || 0;
            let types = achatUnite.checked ? '1' : '0';
            let consignation = 'consigné';

            if (quantite <= 0) {
                alert("Veuillez saisir une quantité valide.");
                return;
            }
            totalQuantiteUnite += achatUnite.checked ? quantite : 0;
            tot.innerHTML = totalQuantiteUnite;
            let total = avec.checked ?
                prix * quantite :
                (prix + prix_consignation) * quantite;
            c20.innerHTML = Math.ceil(totalQuantiteUnite / 20);
            c24.innerHTML = Math.ceil(totalQuantiteUnite / 24);
            reste2.innerHTML = totalQuantiteUnite < 20 ? 0 : totalQuantiteUnite % 20;
            reste1.innerHTML = totalQuantiteUnite < 24 ? 0 : totalQuantiteUnite % 24;

            let totalenvoie = Math.ceil(totalQuantiteUnite / 24);
            let totalconsignecageot = avec.checked ?
                (cgt_checkbox.checked ? prix * conditionnement * quantite : (prix * conditionnement * quantite) + (prix_cgt * quantite)) :
                (cgt_checkbox.checked ? (prix_consignation + prix) * conditionnement * quantite : ((prix_consignation + prix) * conditionnement * quantite) + (prix_cgt * quantite));
            let totalcageot = vars ?
                (prix + prix_consignation) * quantite * conditionnement + (prix_cgt * quantite) :
                totalconsignecageot;

            let totalActuel = parseInt(final.innerHTML, 10) || 0;
            final.innerHTML = totalActuel + (achatUnite.checked ? total : totalconsignecageot);

            let newRow = `<tr data-tot=${achatUnite.checked ? quantite : 0} data-total="${achatUnite.checked ? total : totalconsignecageot}" data-id="${articleId}">
                <td>${articleNom}</td>
                <td>${prix} Ar</td>
                <td>${prix + prix_consignation} Ar</td>
                <td >${quantite} ${achatUnite.checked ? 'bouteille' : 'cageot (' + conditionnement + ' bouteilles / CGT)'}</td>
                <td>${achatUnite.checked ? 'non conditionné' : (cgt_checkbox.checked ? '<span class="text-success">oui</span>(non consigné)' : '<span class="text-danger">non</span>(3000 ar / CGT)')}</td>
                <td>${avec.checked ? '<span class="text-success">oui</span>(non consigné)' : '<span class="text-danger">non</span>(700ar/BTL)'}</td>
                <td></td>
                <td>${achatUnite.checked ? total : totalconsignecageot} Ar</td>
                <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
            </tr>`;

            document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

            let hiddenInputs = document.getElementById('hiddenInputs');
            hiddenInputs.insertAdjacentHTML('beforeend', `
                <div class="hidden-group" data-id="${articleId}">
                    <input type="hidden" name="articles[]" value="${articleId}">
                    <input type="hidden" name="quantites[]" value="${quantite}">
                    <input type="hidden" name="prices[]" value="${prix}">
                    <input type="hidden" name="dateventes[]" value="${datevente}">
                    <input type="hidden" name="types[]" value="${types}">
                    <input type="hidden" name="consignations[]" value="${avec.checked && cgt_checkbox.checked ? '1' : '0'}">
                    <input type="hidden" name="bouteilles[]" value="${avec.checked ? '1' : '0'}">
                    <input type="hidden" name="cageots[]" value="${cgt_checkbox.checked ? '1' : '0'}">
                    <input type="hidden" name="quantite_embale" value="${totalenvoie}">

                </div>
            `);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeArticle')) {
                let row = e.target.closest('tr');
                let totalRow = parseInt(row.getAttribute('data-total'), 10) || 0;
                let articleId = row.getAttribute('data-id');
                let tots = parseInt(row.getAttribute('data-tot'), 10) || 0;
                // Supprimer la ligne du tableau
                row.remove();

                // Mettre à jour le total final
                let totalActuel = parseInt(final.innerHTML, 10) || 0;
                final.innerHTML = totalActuel - totalRow;
                totalQuantiteUnite -= tots;
                tot.innerHTML = totalQuantiteUnite;
                // Supprimer les inputs cachés associés
                let hiddenGroup = document.querySelector(`.hidden-group[data-id="${articleId}"]`);
                if (hiddenGroup) {
                    hiddenGroup.remove();
                }
            }
        });

    });
</script>

@endsection