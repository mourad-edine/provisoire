@extends('layouts.AdminLayout')

@section('title', 'Achat emballages')

@section('content')
<style>
    .select2-container--default .select2-selection--single {
    border: 1px solid #d1d5db !important;
    border-radius: 0.5rem !important;
    height: 40px !important;
    padding: 0.75rem 1rem !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
    right: 8px !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5 !important;
    padding: 0 !important;
}
</style>
<div class="container mx-auto p-4">
    <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
        <div>
            <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <a href="{{ route('emballage.achat') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('emballage.achat') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-cart-plus mr-1"></i> Achat d'emballage
                    </a>
                </li>
                <li class="mr-2" role="presentation">
                    <a href="{{ route('depense.historique') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.faible.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-list mr-1"></i> Historique des achats
                    </a>
                </li>
               
            </ul>
        </div>
        <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>
    <!-- Form Container -->
    <div class="mb-6 bg-white p-6 shadow-sm border border-gray-200">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-800 rounded">
            {{ session('error') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div id="form-container">
            <!-- Premier formulaire d'ajout -->
            <div class="item-form grid grid-cols-12 gap-4 items-end mb-4 p-4 bg-gray-50 border border-gray-100">
                <!-- Checkbox for selection type -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type de sélection</label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="toggle-selection form-checkbox h-5 w-5 text-blue-600" onchange="toggleSelection(this)">
                        <span class="ml-2 text-sm text-gray-600">Article (sinon cageot)</span>
                    </label>
                </div>
                <!-- Packaging Type Dropdown -->
                <div class="col-span-2 packaging-type-container">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
                    <select class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">Sélectionner</option>
                        @foreach($emballages as $emballage)
                        <option value="{{ $emballage->id }}">{{ $emballage->nom_emballage }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Article Name Input with Select2 -->
                <div class="col-span-2 article-name-container hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
                    <select  class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500 select2">
                        <option value="">Sélectionner</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}">{{ $article->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Price Input -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (Ar)</label>
                    <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
                </div>
                <!-- Quantity Input -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
                    <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
                </div>
                <!-- Subtotal Display -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (Ar)</label>
                    <input type="text" class="subtotal w-full border border-gray-300 px-3 py-2 text-sm bg-gray-100 font-medium" readonly placeholder="0.00">
                </div>
                <!-- Add Button for first row only -->
                <div class="col-span-2">
                    <button onclick="addNewFields()" class="w-full bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-start">
            <button onclick="addNewFields()" class="bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter
            </button>
        </div>
    </div>
    <!-- Total Amount and Actions -->
    <div class="bg-white p-6 shadow-sm border border-gray-200">
        <div class="flex justify-between items-center">
            <div class="text-lg font-semibold text-gray-800">
                Total des articles: <span id="items_count">0</span>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">Net à payer: <span id="total_amount" class="text-blue-600">0.00</span> Ar</h2>
                <button onclick="openConfirmModal()" class="mt-3 bg-green-600 text-white px-6 py-2 text-sm font-medium hover:bg-green-700 transition duration-200">
                    Valider l'achat
                </button>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal -->
    <div id="confirm_modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 shadow-lg w-full max-w-md mx-4 border border-gray-300">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Confirmation de l'achat</h2>
            <div class="mb-4 p-4 bg-gray-50 border border-gray-200">
                <p class="text-sm text-gray-600">Nombre d'articles: <span id="modal_items_count" class="font-semibold">0</span></p>
                <p class="text-lg font-bold text-gray-800 mt-2">Net à payer: <span id="modal_total_amount" class="text-blue-600">0.00</span> Ar</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeConfirmModal()" class="bg-gray-500 text-white px-4 py-2 text-sm font-medium hover:bg-gray-600 transition duration-200">
                    Annuler
                </button>
                <form id="purchaseForm" method="POST" action="{{ route('depense.emballage') }}">
                    @csrf
                    <input type="hidden" name="items" id="items_input">
                    <input type="hidden" name="total_amount" id="total_amount_input">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 text-sm font-medium hover:bg-green-700 transition duration-200">
                        Confirmer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let formCounter = 1;

    // Initialize Select2 on page load
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Sélectionner un article",
            allowClear: true
        });
    });

    // Toggle between packaging type and article name inputs
    function toggleSelection(checkbox) {
        const formGroup = checkbox.closest('.item-form');
        const packagingContainer = formGroup.querySelector('.packaging-type-container');
        const articleContainer = formGroup.querySelector('.article-name-container');
        const packagingSelect = formGroup.querySelector('.packaging-type');
        const articleSelect = formGroup.querySelector('.article-name');

        if (checkbox.checked) {
            // Show article, hide packaging
            packagingContainer.classList.add('hidden');
            articleContainer.classList.remove('hidden');
            packagingSelect.value = '';
            $(packagingSelect).prop('disabled', true);
            $(articleSelect).prop('disabled', false).trigger('change');
        } else {
            // Show packaging, hide article
            articleContainer.classList.add('hidden');
            packagingContainer.classList.remove('hidden');
            articleSelect.value = '';
            $(articleSelect).prop('disabled', true).trigger('change');
            $(packagingSelect).prop('disabled', false);
        }

        // Reinitialize Select2 for article select
        $(articleSelect).select2({
            placeholder: "Sélectionner un article",
            allowClear: true
        });
    }

    // Calculate subtotal for a specific form
    function calculateSubtotal(element) {
        const formGroup = element.closest('.item-form');
        const price = parseFloat(formGroup.querySelector('.price').value) || 0;
        const quantity = parseInt(formGroup.querySelector('.quantity').value) || 0;
        const subtotal = (price * quantity).toFixed(2);
        formGroup.querySelector('.subtotal').value = subtotal;
        updateTotal();
    }

    // Create new form fields
    function addNewFields() {
        formCounter++;
        const formContainer = document.getElementById('form-container');
        const newForm = document.createElement('div');
        newForm.className = 'item-form grid grid-cols-12 gap-4 items-end mb-4 p-4 bg-white border border-gray-100';
        newForm.innerHTML = `
            <!-- Checkbox for selection type -->
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Type de sélection</label>
                <label class="inline-flex items-center">
                    <input type="checkbox" class="toggle-selection form-checkbox h-5 w-5 text-blue-600" onchange="toggleSelection(this)">
                    <span class="ml-2 text-sm text-gray-600">Article (sinon cageot)</span>
                </label>
            </div>
            <!-- Packaging Type Dropdown -->
            <div class="col-span-2 packaging-type-container">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
                <select class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    <option value="">Sélectionner</option>
                    @foreach($emballages as $emballage)
                    <option value="{{ $emballage->id }}">{{ $emballage->nom_emballage }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Article Name Input with Select2 -->
            <div class="col-span-2 article-name-container hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
                <select class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500 select2">
                    <option value="">Sélectionner</option>
                    @foreach($articles as $article)
                    <option value="{{ $article->id }}">{{ $article->nom }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Price Input -->
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (Ar)</label>
                <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
            </div>
            <!-- Quantity Input -->
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
                <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
            </div>
            <!-- Subtotal Display -->
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (Ar)</label>
                <input type="text" class="subtotal w-full border border-gray-300 px-3 py-2 text-sm bg-gray-100 font-medium" readonly placeholder="0.00">
            </div>
            <!-- Remove Button for additional forms -->
            <div class="col-span-2">
                <button onclick="removeForm(this)" class="w-full bg-red-600 text-white px-4 py-2 text-sm font-medium hover:bg-red-700 transition duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Supprimer
                </button>
            </div>
        `;
        formContainer.appendChild(newForm);
        // Initialize Select2 for the new article select
        $(newForm).find('.select2').select2({
            placeholder: "Sélectionner un article",
            allowClear: true
        });
    }

    // Remove form fields
    function removeForm(button) {
        const formGroup = button.closest('.item-form');
        formGroup.remove();
        updateTotal();
    }

    // Update total amount and items count
    function updateTotal() {
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;
        let validItemsCount = 0;

        subtotals.forEach(subtotalInput => {
            const value = parseFloat(subtotalInput.value) || 0;
            total += value;
            if (value > 0) {
                validItemsCount++;
            }
        });

        document.getElementById('total_amount').textContent = total.toFixed(2);
        document.getElementById('modal_total_amount').textContent = total.toFixed(2);
        document.getElementById('items_count').textContent = validItemsCount;
        document.getElementById('modal_items_count').textContent = validItemsCount;
    }

    // Get all items data for submission
    function getAllItems() {
        const forms = document.querySelectorAll('.item-form');
        const items = [];

        forms.forEach((form) => {
            const isArticle = form.querySelector('.toggle-selection').checked;
            const packagingType = form.querySelector('.packaging-type').value;
            const articleName = form.querySelector('.article-name').value;
            const price = parseFloat(form.querySelector('.price').value) || 0;
            const quantity = parseInt(form.querySelector('.quantity').value) || 0;
            const subtotal = parseFloat(form.querySelector('.subtotal').value) || 0;

            if ((isArticle ? articleName : packagingType) && price > 0 && quantity > 0 && subtotal > 0) {
                items.push({
                    type: isArticle ? 'article' : 'packaging',
                    id: isArticle ? articleName : packagingType,
                    unit_price: price,
                    quantity: quantity,
                    subtotal: subtotal
                });
            }
        });

        return items;
    }

    // Open confirmation modal
    function openConfirmModal() {
        const items = getAllItems();
        if (items.length === 0) {
            alert('Veuillez ajouter au moins un article valide avant de valider.');
            return;
        }

        const totalAmount = document.getElementById('total_amount').textContent;
        document.getElementById('items_input').value = JSON.stringify(items);
        document.getElementById('total_amount_input').value = totalAmount;
        document.getElementById('confirm_modal').classList.remove('hidden');
    }

    // Close confirmation modal
    function closeConfirmModal() {
        document.getElementById('confirm_modal').classList.add('hidden');
    }

    // Handle form submission
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        const items = getAllItems();
        if (items.length === 0) {
            e.preventDefault();
            alert('Aucun article valide à soumettre.');
            return;
        }
    });

    // Reset form after successful submission
    function resetForm() {
        const formContainer = document.getElementById('form-container');
        formContainer.innerHTML = `
            <div class="item-form grid grid-cols-12 gap-4 items-end mb-4 p-4 bg-gray-50 border border-gray-100">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type de sélection</label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="toggle-selection form-checkbox h-5 w-5 text-blue-600" onchange="toggleSelection(this)">
                        <span class="ml-2 text-sm text-gray-600">Article (sinon cageot)</span>
                    </label>
                </div>
                <div class="col-span-2 packaging-type-container">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
                    <select class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">Sélectionner</option>
                        @foreach($emballages as $emballage)
                        <option value="{{ $emballage->id }}">{{ $emballage->nom_emballage }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2 article-name-container hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
                    <select class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500 select2">
                        <option value="">Sélectionner</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}">{{ $article->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (Ar)</label>
                    <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
                    <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (Ar)</label>
                    <input type="text" class="subtotal w-full border border-gray-300 px-3 py-2 text-sm bg-gray-100 font-medium" readonly placeholder="0.00">
                </div>
                <div class="col-span-2">
                    <button onclick="addNewFields()" class="w-full bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter
                    </button>
                </div>
            </div>
        `;
        formCounter = 1;
        updateTotal();
        $('.select2').select2({
            placeholder: "Sélectionner un article",
            allowClear: true
        });
    }

    // Reset form after successful submission
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            resetForm();
        });
    </script>
    @endif
</script>

@endsection