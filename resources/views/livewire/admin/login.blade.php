<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                        @if($errorMessage)
                            <div class="alert alert-danger" role="alert">
                                {{ $errorMessage }}
                            </div>
                        @endif
                        <form wire:submit="authenticate" class="user" method="post">
                            @csrf
                            <div class="form-group">
                                <input
                                    type="email"
                                    class="form-control form-control-user"
                                    wire:model="form.email"
                                    placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <input
                                    type="password"
                                    class="form-control form-control-user"
                                    wire:model="form.password"
                                    placeholder="Your Password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input
                                        id="customCheck"
                                        value="1"
                                        type="checkbox"
                                        class="custom-control-input"
                                        wire:model="form.rememberme">
                                    <label class="custom-control-label" for="customCheck">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                            <hr>
                            <p>&nbsp;</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

