@extends('layouts.AdminLayout')

@section('title', 'Achat emballages')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
        <h5 class="textrounded-md font-semibold flex items-center text-gray-800">
            <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a1 1 0 100 2 1 1 0 000-2zm-10 2H3" />
            </svg>
            Nouvel achat d'emballage
        </h5>
        <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>
    <!-- Form Container -->
    <div class="mb-6 bg-white p-6 shadow-sm border border-gray-200">
        <div id="form-container">
            <!-- Premier formulaire d'ajout -->
            <div class="item-form grid grid-cols-12 gap-4 items-end mb-4 p-4 bg-gray-50 border border-gray-100">
                <!-- Packaging Type Dropdown -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
                    <select onchange="toggleInputs(this)" class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">Sélectionner</option>
                        <option value="bottle_30_33cl">Bouteille 30-33cl</option>
                        <option value="crate_6">Cageot de 6</option>
                        <option value="box_12">Caisse de 12</option>
                    </select>
                </div>

                <!-- Article Name Input -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
                    <input type="text" oninput="toggleInputs(this)" class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Ex: Bouteille Coca">
                </div>

                <!-- Price Input -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (€)</label>
                    <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
                </div>

                <!-- Quantity Input -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
                    <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
                </div>

                <!-- Subtotal Display -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (€)</label>
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
                    <button onclick="addNewFields()" class=" bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 transition duration-200 flex items-center justify-center">
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
                <h2 class="text-xl font-bold text-gray-800">Net à payer: <span id="total_amount" class="text-blue-600">0.00</span> €</h2>
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
                <p class="text-lg font-bold text-gray-800 mt-2">Net à payer: <span id="modal_total_amount" class="text-blue-600">0.00</span> €</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeConfirmModal()" class="bg-gray-500 text-white px-4 py-2 text-sm font-medium hover:bg-gray-600 transition duration-200">
                    Annuler
                </button>
                <form id="purchaseForm" method="POST" action="#">
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

<script>
    let formCounter = 1;

    // Toggle between packaging type and article name inputs
    function toggleInputs(element) {
        const formGroup = element.closest('.item-form');
        const packagingType = formGroup.querySelector('.packaging-type');
        const articleName = formGroup.querySelector('.article-name');

        if (element.classList.contains('packaging-type') && element.value) {
            articleName.value = '';
            articleName.disabled = true;
        } else if (element.classList.contains('article-name') && element.value) {
            packagingType.value = '';
            packagingType.disabled = true;
        } else {
            packagingType.disabled = false;
            articleName.disabled = false;
        }
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
        <!-- Packaging Type Dropdown -->
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
            <select onchange="toggleInputs(this)" class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                <option value="">Sélectionner</option>
                <option value="bottle_30_33cl">Bouteille 30-33cl</option>
                <option value="crate_6">Cageot de 6</option>
                <option value="box_12">Caisse de 12</option>
            </select>
        </div>

        <!-- Article Name Input -->
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
            <input type="text" oninput="toggleInputs(this)" class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Ex: Bouteille Coca">
        </div>

        <!-- Price Input -->
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (€)</label>
            <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
        </div>

        <!-- Quantity Input -->
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
            <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
        </div>

        <!-- Subtotal Display -->
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (€)</label>
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

            // Compter seulement les lignes avec sous-total > 0
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

        forms.forEach((form, index) => {
            const packagingType = form.querySelector('.packaging-type').value;
            const articleName = form.querySelector('.article-name').value;
            const price = parseFloat(form.querySelector('.price').value) || 0;
            const quantity = parseInt(form.querySelector('.quantity').value) || 0;
            const subtotal = parseFloat(form.querySelector('.subtotal').value) || 0;

            // Inclure seulement les éléments valides
            if ((packagingType || articleName) && price > 0 && quantity > 0 && subtotal > 0) {
                items.push({
                    packaging_type: packagingType,
                    article_name: articleName,
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

        // Préparer les données pour l'envoi POST
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

        // Les données sont déjà préparées dans les champs cachés
        console.log('Soumission des données:', {
            items: items,
            total_amount: document.getElementById('total_amount_input').value
        });
    });

    // Réinitialiser le formulaire après soumission réussie
    function resetForm() {
        const formContainer = document.getElementById('form-container');
        formContainer.innerHTML = `
        <div class="item-form grid grid-cols-12 gap-4 items-end mb-4 p-4 bg-gray-50 border border-gray-100">
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'emballage</label>
                <select onchange="toggleInputs(this)" class="packaging-type w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    <option value="">Sélectionner</option>
                    <option value="bottle_30_33cl">Bouteille 30-33cl</option>
                    <option value="crate_6">Cageot de 6</option>
                    <option value="box_12">Caisse de 12</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'article</label>
                <input type="text" oninput="toggleInputs(this)" class="article-name w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="Ex: Bouteille Coca">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Prix unitaire (€)</label>
                <input type="number" step="0.01" min="0" oninput="calculateSubtotal(this)" class="price w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="0.00">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité</label>
                <input type="number" min="1" oninput="calculateSubtotal(this)" class="quantity w-full border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500" placeholder="1">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sous-total (€)</label>
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
    }
</script>

<!-- Script pour la réinitialisation après soumission réussie -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        resetForm();
    });
</script>
@endif

@endsection