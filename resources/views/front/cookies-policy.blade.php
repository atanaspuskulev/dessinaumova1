@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Cookies Policy</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                This Cookies Policy explains how Desi Naumova website ("we", "us", "our") uses cookies and similar
                technologies to recognize you when you visit our website at {{ config('app.url') }} ("Website").
                It explains what these technologies are, why we use them, and your rights to control our use of them.
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <ol>
                    <li><a href="#introduction">Introduction</a></li>
                    <li><a href="#what-are-cookies">What Are Cookies?</a>
                    <li><a href="#types-of-cookies">Types of Cookies We Use</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="introduction">1. Introduction</h3>
                By using our Website, you consent to the use of cookies in accordance with this Cookies Policy.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="what-are-cookies">2. What Are Cookies?</h3>
                Cookies are small data files that are placed on your computer or mobile device when you visit a website.
                Cookies are widely used by website owners to make their websites work, or to work more efficiently,
                as well as to provide reporting information.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3">
                <h3 id="types-of-cookies">3. Types of Cookies We Use</h3>
                Common categories that we're using cookies include:
                <ul>
                    <li>Payments</li>
                    <li>Storing Cart products</li>
                    <li>Track added in-cart products</li>
                    <li>Administration purposes</li>
                    <li>External 3rd party, such as (but not limited to) Google Analytics</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
