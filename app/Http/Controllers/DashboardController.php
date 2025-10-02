<?php

namespace App\Http\Controllers;

use App\Models\Resenha;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $resenhasRecentes = Resenha::with(['user', 'livro'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $livrosPopulares = Livro::withCount('resenhas')
            ->orderBy('resenhas_count', 'desc')
            ->take(8)
            ->get();

        $totalUsuarios = User::count();
        $totalLivros = Livro::count();

        return view('dashboard', compact(
            'resenhasRecentes',
            'livrosPopulares',
            'totalUsuarios',
            'totalLivros'
        ));
    }
}