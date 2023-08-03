<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;
    public string $errorMessage;

    #[Layout('layouts.admin_auth')]
    public function render(): View
    {
        return view('livewire.admin.login')
            ->layout('layouts.admin_auth');
    }

    public function authenticate()
    {
        $form = $this->form->all();
        if(Auth::attempt(['email' => $form['email'], 'password' => $form['password']], $form['rememberme'])) {
            return redirect()->route('admin.home');
        }
        $this->errorMessage = 'Invalid credentials. Please try again.';
    }

}
