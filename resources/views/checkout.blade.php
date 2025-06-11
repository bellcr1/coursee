@extends('layouts.app')

@section('content')
<!-- Checkout Section Begin -->
<script src="https://js.stripe.com/v3/"></script>

<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form id="payment-form" action="{{ route('courses.purchase', $course->id) }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-8 col-md-7 mb-4 mb-md-0">
                        <div class="checkout__input">
                            <p>Cardholder Name<span>*</span></p>
                            <input type="text" id="cardholder-name" name="cardholder_name" placeholder="Full name on the card" required>
                        </div>

                        <!-- Stripe Card Element -->
                        <div class="checkout__input">
                            <p>Card Details<span>*</span></p>
                            <div id="card-element" class="form-control" style="padding:10px; border:1px solid #ccc; border-radius:5px;"></div>
                            <div id="card-errors" role="alert" style="color:red; margin-top:10px;"></div>
                            
                        </div>

                        <div class="checkout__input">
                            <p>Billing Address<span>*</span></p>
                            <input type="text" name="billing_address" placeholder="Street, City, Country" required>
                        </div>

                        <div class="checkout__input__checkbox">
                            <label for="save_card" class="d-flex align-items-center">
                                <input type="checkbox" id="save_card" name="save_card" style="margin-right:8px;">
                                <span class="checkmark"></span>
                                Save card for future?
                            </label>
                        </div>

                        <div class="checkout__input">
                            <p>Order Notes</p>
                            <input type="text" name="order_notes" placeholder="Notes about your order, e.g. delivery instructions.">
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4 col-md-5">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                <li>{{ $course->title }} <span>{{ number_format($course->price, 2) }} TND</span></li>
                            </ul>
                            @php
                                $tax = $course->price * 0.15;
                                $total = $course->price + $tax;
                            @endphp
                            <div class="checkout__order__subtotal">Tax (15%) <span>{{ number_format($tax, 2) }} EUR</span></div>
                            <div class="checkout__order__total">Total <span>{{ number_format($total, 2) }} EUR</span></div>
                            <input type="text" id="price"  value="{{ number_format($total, 2) }}" hidden>

                            <button id="submit" class="site-btn">PLACE ORDER</button>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>



<script>
    const stripe = Stripe("pk_test_51RXBLMRjSelEp71V2WHMwbfjeyO474vOX1RxfbdOg4OINxDWpVPnZT8cbEIhcgC8xii7mh1r5LhmbQclaKP7wXTq00F6ner6uw");
    const elements = stripe.elements();
    const card = elements.create("card", {
      hidePostalCode: true
    });
    card.mount("#card-element");
  
    const form = document.getElementById("payment-form");
  
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
  
      const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: "card",
        card: card,
      });
  
      if (error) {
        document.getElementById("payment-result").textContent = "Erreur: " + error.message;
      } else { 
        // ✅ نبعثوا paymentMethod.id لل API
        fetch("/api/payment", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}" // إذا تستعمل Blade
          },
          body: JSON.stringify({
            price: {{ $total }}, 
            payment_method: paymentMethod.id,
            course_id: {{ $course->id }},
            user_id:{{ Auth::id() }}

          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert ("✅ Paiement confirmé !");
            fetch("{{ route('courses.purchase', $course->id) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            payment_success: true,
                            course_id: {{ $course->id }},
                        })
                    })
                    .then(res => {
                        if (res.ok) {
                            window.location.href = "{{ route('courses.show', $course->id) }}";
                        } else {
                            alert("❌ Erreur lors de l'enregistrement de l'achat.");
                        }
                    });

            console.log(data);
          } else {
            alert ("❌ Erreur paiement: " + data.error);
          }
        })
        .catch(err => {
            alert ("❌ Erreur serveur: " + err.message);

        });
      }
    });
  </script>
  
<style>
    /* Main Checkout Styles */
    .checkout {
        padding: 80px 0;
        background-color: #f8f9fa;
    }
    
    .checkout__form {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .checkout__form h4 {
        color: #2d4059;
        font-weight: 700;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    /* Input Fields */
    .checkout__input {
        margin-bottom: 20px;
    }
    
    .checkout__input p {
        color: #555;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .checkout__input p span {
        color: #ff4a52;
    }
    
    .checkout__input input {
        width: 100%;
        height: 50px;
        padding: 0 15px;
        border: 1px solid #e1e1e1;
        border-radius: 4px;
        font-size: 14px;
        color: #555;
        transition: all 0.3s;
    }
    
    .checkout__input input:focus {
        border-color: #2d4059;
        outline: none;
    }
    
    .checkout__input__add {
        margin-bottom: 15px;
    }
    
    /* Checkbox Styles */
    .checkout__input__checkbox {
        position: relative;
        margin-bottom: 20px;
    }
    
    .checkout__input__checkbox label {
        color: #555;
        font-weight: 500;
        cursor: pointer;
        padding-left: 30px;
    }
    
    .checkout__input__checkbox input {
        position: absolute;
        visibility: hidden;
    }
    
    .checkout__input__checkbox .checkmark {
        position: absolute;
        left: 0;
        top: 2px;
        height: 18px;
        width: 18px;
        border: 1px solid #ddd;
        border-radius: 2px;
    }
    
    .checkout__input__checkbox input:checked ~ .checkmark {
        background-color: #2d4059;
        border-color: #2d4059;
    }
    
    .checkout__input__checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .checkout__input__checkbox input:checked ~ .checkmark:after {
        display: block;
    }
    
    /* Order Summary */
    .checkout__order {
        background: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    
    .checkout__order h4 {
        color: #2d4059;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .checkout__order__products {
        font-weight: 600;
        color: #555;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }
    
    .checkout__order ul {
        margin: 20px 0;
        padding: 0;
        list-style: none;
    }
    
    .checkout__order ul li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: #555;
    }
    
    .checkout__order__subtotal,
    .checkout__order__total {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        color: #555;
    }
    
    .checkout__order__total {
        font-weight: 700;
        color: #2d4059;
        font-size: 18px;
        border-bottom: none;
    }
    
    /* Button */
    .site-btn {
        display: inline-block;
        background: #2d4059;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 14px 30px;
        border-radius: 4px;
        border: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        width: 100%;
        text-align: center;
    }
    
    .site-btn:hover {
        background: #1a2a40;
        color: #fff;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .checkout {
            padding: 40px 0;
        }
        
        .checkout__form {
            padding: 25px;
        }
        
        .checkout__order {
            margin-top: 30px;
        }
    }
    
    
</style>
<!-- Checkout Section End -->
<footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Mentor</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>


  </footer>
    @endsection
