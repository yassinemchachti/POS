<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueMart Pro - Premium Supermarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0A285F;
            --secondary-blue: #0077B6;
            --accent-gold: #FFC857;
            --fresh-ice: #CAF0F8;
        }

        body {
            background: var(--fresh-ice);
            font-family: 'Segoe UI', system-ui;
        }

        .navbar {
            background: linear-gradient(45deg, var(--primary-blue), var(--secondary-blue)) !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(10, 40, 95, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background: white;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(10, 40, 95, 0.15);
        }

        .category-tag {
            background: var(--secondary-blue);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .promo-banner {
            background: linear-gradient(45deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-radius: 8px;
            padding: 1.5rem;
        }

        .cart-summary {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(10, 40, 95, 0.1);
            border: 1px solid rgba(10, 40, 95, 0.05);
        }

        .price-tag {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .btn-premium {
            background: var(--primary-blue);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-premium:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
        }

        .nav-icon {
            font-size: 1.25rem;
            margin-right: 8px;
        }

        .product-image {
            height: 200px;
            object-fit: contain;
            padding: 15px;
        }

        .table-cart-summary td {
            padding: 0.75rem 0;
            vertical-align: middle;
        }

        .table-cart-summary tr:not(:last-child) {
            border-bottom: 1px solid #dee2e6;
        }

        .department-badge {
            padding: 0.8rem 1.2rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            background: var(--fresh-ice);
            color: var(--primary-blue);
            font-weight: 500;
        }

        .product-grid {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.05);
        }

        .checkout-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }
    </style>
</head>

<body>

    <!-- Premium Navigation -->
    @livewire('pos')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
