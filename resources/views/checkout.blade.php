@extends('layouts.app')

@section('content')
 <!-- Checkout Section Begin -->
 <section class="checkout spad">
        <div class="container">
           
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="{{ route('courses.purchase', $course->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Fist Name<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Last Name<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Country<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" placeholder="Street Address" class="checkout__input__add">
                                <input type="text" placeholder="Apartment, suite, unite ect (optinal)">
                            </div>
                            <div class="checkout__input">
                                <p>Town/City<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Country/State<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Postcode / ZIP<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="checkout__input__checkbox">
                                <label for="diff-acc">
                                    Ship to a different address?
                                    <input type="checkbox" id="diff-acc">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input">
                                <p>Order notes<span>*</span></p>
                                <input type="text"
                                    placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    <li>{{$course->title}} <span>{{$course->price}}</span></li>
                                </ul>
                                @php
                                    $tax = $course->price * 0.15;
                                    $total = $course->price + $tax;
                                @endphp
                                <div class="checkout__order__subtotal">Tax(15%) <span> {{$tax}} </span></div>    

                                
                                <div class="checkout__order__total">Total <span>{{$total}}</span></div>
                               
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Check Payment
                                        <input type="checkbox" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input type="checkbox" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
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