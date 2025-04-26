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

    <!-- Simple Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow-sm mb-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="bi bi-shop me-2"></i>POS System
            </a>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <input type="text" wire:model.live.debounce.500ms="search" class="form-control" 
                        placeholder="Rechercher un produit...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <select id="client-select" wire:model='client_id' class="form-select" style="max-width: 200px;">
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row g-3">
            <!-- Products Section -->
            <div class="col-lg-8">
                <!-- Simple Category Filter -->
                <div class="card mb-3 border-0 rounded shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <button wire:click='filterByFamille()' 
                                class="btn btn-sm btn-outline-secondary rounded-pill">
                                Tous
                            </button>
                            @foreach ($familles as $famille)
                                <button wire:click='filterByFamille({{ $famille->id }})' 
                                    class="btn btn-sm btn-outline-secondary rounded-pill">
                                    {{ $famille->famille }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Cards -->
                <div class="mb-3">
                    @if ($articles->isEmpty())
                        <div class="alert alert-info">
                            Aucun produit trouvé.
                        </div>
                    @endif
                    <div class="row g-3">
                        @foreach ($articles as $article)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 product-card">
                                    <span class="badge bg-secondary position-absolute end-0 m-2">
                                        @php
                                            $stock = $article->stock - $article->DetailsBL->sum('qnt') ;
                                        @endphp
Stock: {{ $stock   }}
                                    </span>
                                    <img src="{{ $article->photo }}" class="card-img-top p-2" 
                                        alt="{{ $article->designation }}" style="height: 160px; object-fit: contain;">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-truncate">{{ $article->designation }}</h6>
                                        <p class="card-text text-primary fw-bold mt-auto">{{ number_format($article->prix_ht, 2) }} DH</p>
                                        <button wire:click='addToPanier({{ $article->id }})' 
                                            class="btn btn-sm btn-outline-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Ajouter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 1rem;">
                    <div class="card-header bg-light py-2">
                        <h5 class="mb-0 text-secondary">
                            <i class="bi bi-cart3 me-2"></i>Panier
                        </h5>
                    </div>
                    <div class="card-body">
                        <button wire:click="clear" class="btn btn-sm btn-outline-danger mb-3">
                            <i class="bi bi-trash"></i> Vider le panier
                        </button>
                        
                        @error('client_id')
                            <div class="alert alert-danger py-2 small">{{ $message }}</div>
                        @enderror
                        
                        @session('error')
                            <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
                        @endsession()
                        
                        <!-- Cart Items -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Qté</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (empty($cartItems))
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3 small">
                                                Panier vide
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="small">{{ $item['name'] }}</td>
                                            <td>{{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <input type="number" value="{{ $item['quantity'] }}"
                                                    wire:change="updateCart({{ $item['id'] }}, $event.target.value)" 
                                                    min="1" class="form-control form-control-sm" style="width: 50px;">
                                            </td>
                                            <td>{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td>
                                                <button wire:click="removeFromPanier({{ $item['id'] }})"
                                                    class="btn btn-sm text-danger border-0" aria-label="Remove item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Discount Section -->
                        <div class="mt-2 mb-2">
                            <div class="input-group input-group-sm mb-1">
                                <input type="number" wire:model.live='discount' class="form-control" 
                                    placeholder="Remise">
                                <span class="input-group-text">DH / %</span>
                            </div>
                            <div class="form-check form-check-inline small">
                                <input class="form-check-input" type="radio" name="discountType" 
                                    id="fixedDiscount" value="fixed" wire:model.live="typeDiscount">
                                <label class="form-check-label" for="fixedDiscount">Fixe</label>
                            </div>
                            <div class="form-check form-check-inline small">
                                <input class="form-check-input" type="radio" name="discountType" 
                                    id="percentageDiscount" value="percentage" wire:model.live="typeDiscount">
                                <label class="form-check-label" for="percentageDiscount">%</label>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="d-flex justify-content-between mt-3 mb-2">
                            <span class="text-muted small">Sous-total ({{ count($cartItems) }} articles):</span>
                            <span>{{ $total }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mb-3">
                            <span>Total:</span>
                            <span class="text-primary">{{ $totalWithDiscout }}</span>
                        </div>
                        <button wire:click="saveCart" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Confirmer la commande
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<style>
    .product-card {
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,.125);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
        border-color: #dee2e6;
    }
    .pagination {
        justify-content: center;
    }
    .pagination .page-link {
        color: #6c757d;
        border-radius: 0.25rem;
        margin: 0 2px;
    }
    .pagination .page-item.active .page-link {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }
</style>
</div>




