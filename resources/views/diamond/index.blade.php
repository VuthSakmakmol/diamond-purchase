<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diamond Purchase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for elements */
        h1 {
            font-weight: 700;
            color: var(--bs-info-emphasis); /* Use Bootstrap's info color emphasis */
        }

        .form-label {
            font-weight: 500;
            color: var(--bs-info-emphasis);
        }

        /* Logo hover effect */
        .image-container {
            position: relative;
            width: 150px;
            margin: 0 auto;
        }

        .logo-hover img {
            cursor: pointer;
        }

        /* Styling for grid */
        .diamond-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .diamond-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            background-color: white;
            transition: transform 0.2s ease;
        }

        .diamond-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .diamond-item img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .diamond-item label {
            cursor: pointer;
            font-weight: 500;
        }

        /* Fixed Total Div at the Bottom */
        #totalDiv {
            position: fixed;
            bottom: 0;
            right: 20px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            font-size: 14px;
        }

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
            display: none;
        }
    </style>
</head>
<body class="bg-body-secondary text-info-emphasis">

@if(session('success'))
    <script>
        // Show an alert if a success message is available
        alert('{{ session('success') }}');
    </script>
@endif

<div class="w-25 p-3">
    <img src="{{ asset('images/logo-game.jpg') }}" alt="logo" class="w-75 p-3">
    <p></p>
</div>

<div class="container my-5">
    <h1 class="text-center mb-4">Select Your Diamond Package</h1>

    <!-- Form for selecting diamond packages and entering details -->
    <form id="diamondForm" action="{{ route('choose') }}" method="POST" class="text-center">
        @csrf
        <div class="diamond-grid">
            @foreach($grid as $index => $item)
                <div class="diamond-item">
                    <label>
                        <input type="radio" name="square" value="{{ $index }}" class="btn-check" id="option{{ $index }}" data-price="{{ $item['price'] }}" data-diamonds="{{ $item['diamonds'] ?? 0 }}" data-bonus="{{ $item['bonus_diamonds'] ?? 0 }}" autocomplete="off">
                        <label class="btn btn-outline-primary w-100" for="option{{ $index }}">
                            <img src="{{ asset('images/diamond.jpg') }}" alt="Diamond">
                            <div>
                                @if(isset($item['diamonds']))
                                    {{ $item['diamonds'] }} Diamonds + {{ $item['bonus_diamonds'] ?? 0 }} Bonus
                                @else
                                    {{ $item['bonus_diamonds'] }} Bonus Diamonds
                                @endif
                            </div>
                        </label>
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Input fields -->
        <div class="mb-3 mt-5">
            <label for="field1" class="form-label">Insert Your ID:</label>
            <input type="text" name="field1" id="field1" class="form-control w-50 mx-auto" required>
            <div class="error-message" id="field1Error">Please enter your ID.</div>
        </div>

        <div class="mb-3">
            <label for="field2" class="form-label">Insert Your ID(Server):</label>
            <input type="text" name="field2" id="field2" class="form-control w-50 mx-auto" required>
            <div class="error-message" id="field2Error">Please enter your server ID.</div>
        </div>

        <!-- Terms & Conditions -->
        <div class="form-check mb-3">
            <label class="form-check-label" for="termsCheck">
                <input class="form-check-input" type="checkbox" value="" id="termsCheck" required>
                I agree to the <a href="#">Terms & Conditions</a>.
            </label>
            <div class="error-message" id="termsCheckError">Terms & Conditions.</div>
        </div>

        <!-- ABA Logo and QR code popup -->
        <div class="image-container text-center mt-5">
            <img src="{{ asset('images/aba.jpg') }}" alt="Click to Show QR Code" data-bs-toggle="modal" data-bs-target="#imageModal" class="logo-hover img-fluid" id="abaLogo" style="border-radius: 35px">
            <div class="error-message" id="abaClickError">Please click on the ABA logo to view the QR code.</div>
        </div>

        <!-- Submit button -->
        <div class="text-center mt-4">
            <button type="submit" id="payButton" class="btn btn-success">Pay</button>
        </div>
    </form>
</div>

<!-- Fixed Total Div at Bottom -->
<div id="totalDiv">
    <h5>Total Selected:</h5>
    <p>Price: <span id="totalPrice">0</span> USD</p>
    <p>Diamonds: <span id="totalDiamonds">0</span></p>
</div>

<!-- Modal for QR Code Pop-Up -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">QR Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('images/QR_code.jpg') }}" class="img-fluid" alt="QR Code" style="width: 250px; height:auto;">
      </div>
      <div class="modal-footer">
        <a href="{{ asset('images/QR_code.jpg') }}" download class="btn btn-primary" style="width: 150px; height:auto;">Save QR Code</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Variables to track ABA click
    let abaClicked = false;

    // ABA logo click event listener
    document.getElementById('abaLogo').addEventListener('click', function() {
        abaClicked = true;
        document.getElementById('abaClickError').style.display = 'none';
    });

    // JavaScript to handle total price and diamonds update
    const radioButtons = document.querySelectorAll('input[type="radio"][name="square"]');
    const totalPrice = document.getElementById('totalPrice');
    const totalDiamonds = document.getElementById('totalDiamonds');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const price = this.getAttribute('data-price');
            const diamonds = parseInt(this.getAttribute('data-diamonds')) + parseInt(this.getAttribute('data-bonus') || 0);
            
            totalPrice.textContent = price;
            totalDiamonds.textContent = diamonds;
        });
    });

    // Handle Payment Submission
    document.getElementById('diamondForm').addEventListener('submit', function(event) {
        let valid = true;

        // Check ID field
        const field1 = document.getElementById('field1').value;
        if (!field1) {
            document.getElementById('field1Error').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('field1Error').style.display = 'none';
        }

        // Check Server ID field
        const field2 = document.getElementById('field2').value;
        if (!field2) {
            document.getElementById('field2Error').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('field2Error').style.display = 'none';
        }

        // Check Terms & Conditions
        const termsCheck = document.getElementById('termsCheck').checked;
        if (!termsCheck) {
            document.getElementById('termsCheckError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('termsCheckError').style.display = 'none';
        }

        // Check ABA logo clicked
        if (!abaClicked) {
            document.getElementById('abaClickError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('abaClickError').style.display = 'none';
        }

        // Prevent form submission if validation failed
        if (!valid) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
