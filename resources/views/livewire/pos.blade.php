<div>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-success-alert', event => {
                Swal.fire({
                    icon: "success",
                    title: event.detail[0].message,
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    </script>


    <nav class="navbar navbar-expand-lg navbar-dark py-3 mb-2">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="bi bi-basket3-fill nav-icon"></i>BlueMart Pro
            </a>
            <div class="d-flex align-items-center gap-4">
                <div class="input-group mb-3 align-items-center">
                    <input type="text" wire:model.live.debounce.500ms="search" class="form-control"
                        placeholder="Rechercher un produit..." aria-label="Search Product"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                            class="bi bi-search"></i></button>
                    <select id="client-select" wire:model='client_id' class="form-select ms-2"
                        style="max-width: 200px;">
                        <option value="">Sélectionner un client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach

                    </select>

                </div>
                {{-- <div class="dropdown">
                    <button class="btn btn-link text-white" type="button">
                        <i class="bi bi-person-circle nav-icon"></i>
                    </button>
                </div>
                <div class="position-relative">
                    <button class="btn btn-link text-white position-relative">
                        <i class="bi bi-cart3 nav-icon"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span>
                    </button>
                </div> --}}
            </div>
        </div>
    </nav>
    <div class="row g-4">
        <div class="col-lg-9">

            <div class="department-nav mb-4 mx-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-filter-circle nav-icon"></i>Familles</h5>
                <div class="d-flex flex-wrap gap-2">
                    <button wire:click='filterByFamille()'
                        class="badge bg-primary text-white rounded-pill p-3 d-flex align-items-center">
                        <i class="bi bi-house-door me-2"></i>All
                    </button>
                    @foreach ($familles as $famille)
                        <button wire:click='filterByFamille({{ $famille->id }})'
                            class="badge bg-primary text-white rounded-pill p-3 d-flex align-items-center">
                            {{ $famille->famille }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Cards Section -->
            <div class="product-grid mt-4 mx-2">
                @if ($articles->isEmpty())
                    <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-box-seam nav-icon"></i>Aucun produit trouvé.
                    </h5>
                @endif
                <div class="row g-4">
                    @foreach ($articles as $article)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-card p-3 text-center h-100">
                                <span class="category-tag">{{ $article->famille->famille }}</span>
                                <img src="{{ $article->photo }}" class="product-image"
                                    alt="{{ $article->designation }}">
                                <h6 class="mt-3">{{ $article->designation }}</h6>
                                <div class="price-tag">{{ number_format($article->prix_ht, 2) }} DH</div>
                                <button wire:click='addToPanier({{ $article->id }})'
                                    class="btn btn-premium mt-3 w-100">Ajouter au panier</button>
                            </div>
                        </div>
                    @endforeach

                    {{ $articles->links() }}
                </div>
            </div>
        </div>


        <!-- Right Side Checkout -->
        <div class="card shadow-sm p-4  rounded-4 w-100" style="max-width: 400px;">
            <button wire:click="clear" class="btn btn-danger mb-3 w-100">
                <i class="bi bi-trash"></i> Vider le panier
            </button>
            @error('client_id')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
            @session('error')
            <p class="text-danger mt-1">{{ session('error') }}</p>
            @endsession()
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-receipt-cutoff"></i> Résumé de la commande</h5>
            <div class="d-flex justify-content-between mb-2">
                <span>Sous-total ({{ count($cartItems) }} articles) :</span>
                <span class="fw-semibold">{{ $total }}</span>
            </div>
            <hr>

            <h6 class="fw-bold mb-2">Liste des Produits</h6>
            <table class="table table-borderless table-sm">
                <thead class="text-muted small">
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody class="small">
                
                       
               
                    @if (empty($cartItems))
                        <tr>
                            <td colspan="5" class="text-center">Aucun produit dans le panier.</td>
                        </tr>
                    @endif
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input type="number" value="{{ $item['quantity'] }}"
                                    wire:change="updateCart({{ $item['id'] }}, $event.target.value)" min="1"
                                    class="form-control form-control-sm" min="1">
                            </td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <button wire:click="removeFromPanier({{ $item['id'] }})"
                                    class="btn btn-danger btn-sm" aria-label="Remove item">
                                    <i class="bi bi-x" role="img" aria-hidden="true"></i>
                                </button>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <hr>
            <h6 class="fw-bold mb-2">Remise</h6>
            <div class="input-group mb-2">
                <input type="number" wire:model.live='discount' class="form-control" placeholder="Discount value">
                <span class="input-group-text">DH / %</span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="discountType" id="fixedDiscount" value="fixed"
                    wire:model.live="typeDiscount">
                <label class="form-check-label" for="fixedDiscount">Fixe</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="discountType" id="percentageDiscount"
                    value="percentage" wire:model.live="typeDiscount">
                <label class="form-check-label" for="percentageDiscount">Pourcentage</label>
            </div>

            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Total:</span>
                <span class="text-primary">{{ $totalWithDiscout }}</span>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button wire:click="saveCart" class="btn btn-success">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </div>
        </div>




    </div>
</div>
