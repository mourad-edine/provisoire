<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- Tailwind CSS -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            padding-top: 60px;
            background-color: #f8f9fa;
        }

        .select2-container {
            z-index: 50 !important;
        }

        .select2-dropdown {
            z-index: 51 !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav style="z-index: 60;" class="fixed top-0 left-0 w-full bg-gray-800 text-white shadow-md py-3">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button class="md:hidden text-white mr-3" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="{{ route('page.accueil') }}" class="text-xl font-bold">Mon Site</a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>

                    <!-- User Space Dropdown -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-user mr-1"></i> Espace utilisateur <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('article.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-700 my-1"></div>
                            <a href="{{ route('commande.liste.vente') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Commandes ventes
                            </a>
                            <a href="{{ route('achat.commande') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Commandes achats
                            </a>
                            <a href="{{ route('depense') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Dépense divers
                            </a>
                            <a href="{{ route('vente.page') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Ventes
                            </a>
                            <a href="{{ route('achat.page') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-shopping-cart mr-2"></i> Achats
                            </a>
                        </div>
                    </div>

                    <!-- Clients & Suppliers -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-users mr-1"></i> Clients & Fournisseurs <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('client.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-users mr-2"></i> Clients
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-truck mr-2"></i> Fournisseurs
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-chart-bar mr-1"></i> Statistique des ventes
                    </a>

                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-cog mr-1"></i> Paramètres
                    </a>

                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-boxes mr-1"></i> Stock
                    </a>
                </div>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu (hidden by default) -->
            <div class="hidden md:hidden mt-4" id="mobile-menu">
                <div class="flex flex-col space-y-3 pb-3">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>

                    <div class="pl-2 border-l border-gray-700 ml-2">
                        <p class="font-medium mb-1"><i class="fas fa-user mr-2"></i> Espace utilisateur</p>
                        <div class="flex flex-col space-y-2 ml-4">
                            <a href="{{ route('article.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-700 my-1"></div>
                            <a href="{{ route('commande.liste.vente') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Commandes ventes
                            </a>
                            <a href="{{ route('achat.commande') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Commandes achats
                            </a>
                            <a href="{{ route('depense') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Dépense divers
                            </a>
                            <a href="{{ route('vente.page') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Ventes
                            </a>
                            <a href="{{ route('achat.page') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-shopping-cart mr-2"></i> Achats
                            </a>
                        </div>
                    </div>

                    <div class="pl-2 border-l border-gray-700 ml-2">
                        <p class="font-medium mb-1"><i class="fas fa-users mr-2"></i> Clients & Fournisseurs</p>
                        <div class="flex flex-col space-y-2 ml-4">
                            <a href="{{ route('client.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-users mr-2"></i> Clients
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-truck mr-2"></i> Fournisseurs
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400">
                        <i class="fas fa-chart-bar mr-2"></i> Statistique des ventes
                    </a>

                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>

                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400">
                        <i class="fas fa-boxes mr-2"></i> Stock
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="container mx-auto px-40 py-6">
        <div class="bg-white shadow-lg rounded-lg p-4">
            <div class="bg-gray-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                <h5 class="text-lg font-bold"><i class="fas fa-cash-register mr-2"></i>Nouvelle achat</h5>
                <a href="{{ url()->previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex justify-between items-center">
                <div><strong>Erreur!</strong> {{ session('error') }}</div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex justify-between items-center">
                <div><strong>Erreur!</strong> Veuillez remplir tous les champs requis.</div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
            <form id="achatForm" method="POST" action="{{ route('achat.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="numero_commande" class="block text-sm font-semibold text-gray-700 mb-1">Numéro de commande</label>
                        <input type="text" id="numero_commande" name="numero" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="dateachat" class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                        <input type="date" id="dateachat" name="dateachat" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="fournisseur" class="block text-sm font-semibold text-gray-700 mb-1">Fournisseur</label>
                        <select id="fournisseur" name="fournisseur_id" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 select2" required>
                            @foreach($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-center border-collapse bg-gray-50 rounded-lg">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="p-3">Article</th>
                                <th class="p-3">Quantité (Cageot/Pack)</th>
                                <th class="p-3">Quantité (Unité)</th>
                                <th class="p-3">Total (Ar)</th>
                                <th class="p-3">Prix unité (Ar)</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesContainer">
                            <tr class="article-row hover:bg-gray-100">
                                <td class="p-3">
                                    <select class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 select2 article-select" data-index="0">
                                        @foreach($articles as $article)
                                        <option value="{{ $article->id }}"
                                            data-prix="{{ $article->prix_achat }}"
                                            data-condi="{{ $article->conditionnement }}"
                                            data-prixcgt="{{ $article->prix_cgt }}"
                                            data-consignation="{{ $article->prix_consignation }}">
                                            {{ $article->nom }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-3">
                                    <input type="number" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantite-input" data-index="0" min="1">
                                </td>
                                <td class="p-3">
                                    <input type="number" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantiteunite-input" data-index="0" min="1">
                                </td>
                                <td class="p-3">
                                    <input type="number" class="w-full border rounded-lg px-3 py-2 bg-gray-100 total-input" data-index="0">
                                </td>
                                <td class="p-3">
                                    <input type="number" class="w-full border rounded-lg px-3 py-2 bg-gray-100 prixunite-input" data-index="0" min="1" step="0.01" readonly>
                                </td>
                                <td class="p-3">
                                    <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center" id="ajouterArticleBtn">
                        <i class="fas fa-plus mr-2"></i>Ajouter un article
                    </button>
                    <div class="text-lg font-bold text-green-600">
                        <span id="grandTotal">0</span> Ar
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center" id="validerCommande">
                        <i class="fas fa-check-circle mr-2"></i>Valider la commande
                    </button>
                </div>
                <div id="hiddenInputs"></div>
            </form>
        </div>

        <!-- Validation Modal -->
        <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-[1070]">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
                <div class="bg-gray-800 text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h5 class="text-lg font-bold"><i class="fas fa-check-circle mr-2"></i>Confirmation de commande</h5>
                    <button onclick="closeModal('validationModal')" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 text-center">
                    <i class="fas fa-question-circle text-4xl text-yellow-500 mb-4"></i>
                    <h5 class="text-lg font-bold mb-4">Voulez-vous valider cette commande ?</h5>
                    <div class="bg-gray-100 p-2 rounded-lg flex justify-between items-center">
                        <span class="font-bold">Montant total:</span>
                        <div><span class="text-lg font-bold text-gray-800" id="modalTotal">0</span><span class="ml-2">Ar</span></div>
                    </div>
                </div>
                <div class="bg-gray-100 p-4 rounded-b-lg flex justify-end gap-2">
                    <button type="button" onclick="closeModal('validationModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <button type="button" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 flex items-center" id="confirmSubmit">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleNavbar() {
            document.getElementById('mainNavbar').classList.toggle('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        $(document).ready(function() {
            $('.select2').select2();

            let articleIndex = 0;

            function calculatePricePerUnit(index) {
                const quantiteCageot = parseFloat($(`.quantite-input[data-index="${index}"]`).val()) || 0;
                const quantiteUnite = parseFloat($(`.quantiteunite-input[data-index="${index}"]`).val()) || 0;
                const total = parseFloat($(`.total-input[data-index="${index}"]`).val()) || 0;
                const selectedOption = $(`.article-select[data-index="${index}"] option:selected`);
                const conditionnement = parseFloat(selectedOption.data('condi')) || 1;

                let prixUnite = 0;
                if (quantiteCageot > 0) {
                    prixUnite = total / (quantiteCageot * conditionnement);
                } else if (quantiteUnite > 0) {
                    prixUnite = total / quantiteUnite;
                }

                if (prixUnite > 0) {
                    $(`.prixunite-input[data-index="${index}"]`).val(prixUnite.toFixed(2));
                } else {
                    $(`.prixunite-input[data-index="${index}"]`).val('');
                }

                updateGrandTotal();
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                $('.total-input').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });
                $('#grandTotal').text(grandTotal.toFixed(2));
                $('#modalTotal').text(grandTotal.toFixed(2));
            }

            function handleQuantiteExclusivity(index) {
                const quantiteCageot = $(`.quantite-input[data-index="${index}"]`);
                const quantiteUnite = $(`.quantiteunite-input[data-index="${index}"]`);

                if (quantiteCageot.val() && quantiteCageot.val() > 0) {
                    quantiteUnite.val('').prop('disabled', true);
                } else if (quantiteUnite.val() && quantiteUnite.val() > 0) {
                    quantiteCageot.val('').prop('disabled', true);
                } else {
                    quantiteCageot.prop('disabled', false);
                    quantiteUnite.prop('disabled', false);
                }
            }

            $(document).on('input', '.quantite-input, .quantiteunite-input, .total-input', function() {
                const index = $(this).data('index');
                handleQuantiteExclusivity(index);
                calculatePricePerUnit(index);
            });

            $(document).on('change', '.article-select', function() {
                const index = $(this).data('index');
                $(`.prixunite-input[data-index="${index}"]`).val('');
                const currentTotal = $(`.total-input[data-index="${index}"]`).val() || '';
                $(`.total-input[data-index="${index}"]`).val(currentTotal);
                updateGrandTotal();
            });

            $('#ajouterArticleBtn').click(function() {
                articleIndex++;
                const newRow = `
                    <tr class="article-row hover:bg-gray-100">
                        <td class="p-3">
                            <select class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 select2 article-select" data-index="${articleIndex}">
                                @foreach($articles as $article)
                                <option value="{{ $article->id }}"
                                        data-prix="{{ $article->prix_achat }}"
                                        data-condi="{{ $article->conditionnement }}"
                                        data-prixcgt="{{ $article->prix_cgt }}"
                                        data-consignation="{{ $article->prix_consignation }}">
                                    {{ $article->nom }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-3">
                            <input type="number" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantite-input" data-index="${articleIndex}" min="1">
                        </td>
                        <td class="p-3">
                            <input type="number" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantiteunite-input" data-index="${articleIndex}" min="1">
                        </td>
                        <td class="p-3">
                            <input type="number" class="w-full border rounded-lg px-3 py-2 bg-gray-100 total-input" data-index="${articleIndex}">
                        </td>
                        <td class="p-3">
                            <input type="number" class="w-full border rounded-lg px-3 py-2 bg-gray-100 prixunite-input" data-index="${articleIndex}" min="1" step="0.01" readonly>
                        </td>
                        <td class="p-3">
                            <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="${articleIndex}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $('#articlesContainer').append(newRow);
                $(`.article-select[data-index="${articleIndex}"]`).select2();
                handleQuantiteExclusivity(articleIndex);
            });

            $(document).on('click', '.remove-article', function() {
                $(this).closest('.article-row').remove();
                updateGrandTotal();
            });

            $('#validerCommande').click(function() {
                let isValid = true;
                $('.article-row').each(function() {
                    const index = $(this).find('.article-select').data('index');
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const total = $(this).find('.total-input').val();

                    if ((!quantite || quantite <= 0) && (!quantiteunite || quantiteunite <= 0) || !total || total <= 0) {
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    alert("Veuillez remplir tous les champs requis pour chaque article (quantité et total)");
                    return;
                }

                prepareHiddenInputs();
                openModal('validationModal');
            });

            let isSubmitting = false;

            $('#confirmSubmit').click(function() {
                if (isSubmitting) return;
                isSubmitting = true;
                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement...';
                setTimeout(() => {
                    $('#achatForm').submit();
                }, 50);
            });

            function prepareHiddenInputs() {
                $('#hiddenInputs').empty();
                $('.article-row').each(function(index) {
                    const sectionIndex = $(this).find('.article-select').data('index');
                    const articleId = $(this).find('.article-select').val();
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const prixUnite = $(this).find('.prixunite-input').val();
                    const total = $(this).find('.total-input').val();

                    $('#hiddenInputs').append(`
                        <input type="hidden" name="articles[]" value="${articleId}">
                        <input type="hidden" name="quantites[]" value="${quantite}">
                        <input type="hidden" name="quantitesunite[]" value="${quantiteunite ? quantiteunite : 0}">
                        <input type="hidden" name="prices[]" value="${prixUnite}">
                        <input type="hidden" name="totals[]" value="${total}">
                    `);
                });
                $('#hiddenInputs').append(`
                    <input type="hidden" name="fournisseur_id" value="${$('#fournisseur').val()}">
                    <input type="hidden" name="dateachat" value="${$('#dateachat').val()}">
                    <input type="hidden" name="numero_commande" value="${$('#numero_commande').val()}">
                `);
            }

            handleQuantiteExclusivity(0);
        });
    </script>
</body>

</html>