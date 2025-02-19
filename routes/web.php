<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//----------------------------------------------USUARIO----------------------------------------------------------------
Route::get('/', [\App\Http\Controllers\AlunoController::class,'index'])->name('login');
Auth::routes(['verify' => true]);

// ---------------------------------------------ALUNO-------------------------------------------------------------------
Route::get('/cadastro',[\App\Http\Controllers\AlunoController::class,'createAluno'])->name('cadastro');
Route::post('/cadastro',[\App\Http\Controllers\AlunoController::class,'storeAluno'])->name('cadastro');
Route::get('/load-cursos/{id}',[\App\Http\Controllers\AlunoController::class, 'loadCursos'])->name('loadCursos');


//----------------------------------------------ADMINISTRADOR-----------------------------------------------------------
Route::group(['middleware'=> ['CheckAdministrador', 'verified']], function(){
    Route::get('/home-administrador',[\App\Http\Controllers\AdministradorController::class, 'index'])->name('home-administrador')->middleware('CheckAdministrador');
    Route::get('/cadastro-servidor',[\App\Http\Controllers\ServidorController::class, 'homeServidor'])->name('cadastro-servidor')->middleware('CheckAdministrador');
    Route::post('/confirmacao-servidor',[\App\Http\Controllers\ServidorController::class, 'storeServidor'])->name('confirmacao-servidor')->middleware('CheckAdministrador');
    Route::get('/cancela-cadastro',[\App\Http\Controllers\ServidorController::class, 'cancel'])->name('cancela-cadastro')->middleware('CheckAdministrador');
    Route::get('/cadastro-biblioteca',[\App\Http\Controllers\BibliotecaController::class,'createBiblioteca'])->name('cadastro-biblioteca');
    Route::post('/cadastro-biblioteca',[\App\Http\Controllers\BibliotecaController::class,'storeBiblioteca'])->name('criar-biblioteca');
    Route::get('/cadastro-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class,'createBibliotecario'])->name('cadastro-bibliotecario');
    Route::post('/criar-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class,'storeBibliotecario'])->name('criar-bibliotecario');
    Route::get('/editar-biblioteca',[\App\Http\Controllers\BibliotecaController::class,'editarBiblioteca'])->name('editar-biblioteca');
    Route::post('/editar-biblioteca',[\App\Http\Controllers\BibliotecaController::class,'atualizarBiblioteca'])->name('atualizar-biblioteca');
    Route::get('/listar-bibliotecas',[\App\Http\Controllers\BibliotecaController::class,'listarBiblioteca'])->name('listar-bibliotecas');
    Route::get('/listar-usuario',[\App\Http\Controllers\UsuarioController::class,'listarUsuario'])->name('listar-usuario');
});

Route::group(['middleware'=> ['CheckAdministradorServidor', 'verified']], function(){
    Route::get('/editar-usuario',[\App\Http\Controllers\UsuarioController::class,'editarUsuario'])->name('editar-usuario');
    Route::post('/editar-usuario',[\App\Http\Controllers\UsuarioController::class,'atualizarUsuario'])->name('atualizar-usuario');
    Route::get('/cadastro-campus',[\App\Http\Controllers\UnidadeController::class,'createCampus'])->name('cadastro-campus');
    Route::post('/cadastro-campus',[\App\Http\Controllers\UnidadeController::class,'storeCampus'])->name('criar-campus');
    Route::get('/gerenciar-campi',[\App\Http\Controllers\UnidadeController::class, 'gerenciarCampi'])->name('gerenciar-campi');
    Route::get('/cadastro-curso',[\App\Http\Controllers\CursoController::class,'createCurso'])->name('cadastro-curso');
    Route::post('/cadastro-curso',[\App\Http\Controllers\CursoController::class,'storeCurso'])->name('criar-curso');
    Route::get('/listar-cursos',[\App\Http\Controllers\CursoController::class,'listarCursos'])->name('listar-cursos');
    Route::get('/editar-cursos',[\App\Http\Controllers\CursoController::class,'editarCurso'])->name('editar-curso');
    Route::post('/editar-cursos',[\App\Http\Controllers\CursoController::class,'atualizarCurso'])->name('atualizar-curso');


});

//----------------------------------------------SERVIDOR----------------------------------------------------------------
Route::group(['middleware'=> ['CheckServidor', 'verified']], function(){

    // Route::post('/filtrar-requisicoes/{curso_id?}', 'RequisicaoController@filtrarCurso')->name('filtrar-requisicoes-post')->middleware('CheckServidor');

    Route::post('/indefere-requisicoes/{requisicao_id?}', [\App\Http\Controllers\RequisicaoController::class, 'indeferirRequisicao'])->name('indefere-requisicoes-post')->middleware('CheckServidor');
    Route::get('/listar-requisicoes', [\App\Http\Controllers\RequisicaoController::class, 'getRequisicoes'])->name('listar-requisicoes')->middleware('CheckServidor');
    Route::get('/relatorio-requisicoes',[\App\Http\Controllers\RequisicaoController::class, 'exibirBusca'])->name('relatorio-requisicoes')->middleware('CheckServidor');
    Route::get('/listar-requisicoes-aluno-servidor/{id}',[\App\Http\Controllers\RequisicaoController::class, 'listarRequisicoesAluno'])->name('listar-requisicoes-servidor')->middleware('CheckServidor');
    Route::post('/relatorio-requisicoes',[\App\Http\Controllers\RequisicaoController::class, 'gerarRelatorio'])->name('listar-relatorio-post')->middleware('CheckServidor');
    Route::get('/pesquisar-aluno',[\App\Http\Controllers\RequisicaoController::class, 'exibirPesquisa'])->name('pesquisar-aluno')->middleware('CheckServidor');
    Route::post('/pesquisar-aluno',[\App\Http\Controllers\RequisicaoController::class, 'pesquisarAluno'])->name('pesquisar-aluno-post')->middleware('CheckServidor');
    Route::post('/listar-requisicoes',[\App\Http\Controllers\RequisicaoController::class, 'concluirRequisicao'])->name('listar-requisicoes-post')->middleware('CheckServidor');
    Route::get('/home-servidor',[\App\Http\Controllers\ServidorController::class, 'index'])->name('home_servidor')->middleware('CheckServidor');
    Route::get('/home-servidor',[\App\Http\Controllers\RequisicaoController::class, 'index'])->name('cadastro-servidor')->middleware('CheckServidor');
    Route::post('/novo-servidor',[\App\Http\Controllers\RequisicaoController::class, 'storeServidor'])->name('novo-servidor')->middleware('CheckServidor');
    Route::get('/alterar-senha-servidor',[\App\Http\Controllers\ServidorController::class, 'alterarSenhaServidor'])->name('alterar-senha-servidor')->middleware('CheckServidor');
    Route::post('/alterar-senha-servidor',[\App\Http\Controllers\ServidorController::class, 'storeAlterarSenhaServidor'])->name('alterar-senha-servidor')->middleware('CheckServidor');
    Route::get('/home-servidor',[\App\Http\Controllers\RequisicaoController::class, 'index'])->name('home_servidor')->middleware('CheckServidor');
    Route::get('/listar-alunos', [\App\Http\Controllers\UsuarioController::class, 'listarAlunos'])->name('listar_alunos');

});
//----------------------------------------------ALUNO---------------------------------------------------
// Route::group(['middleware'=> 'verified'], function(){
Route::group(['middleware' => 'CheckAluno'], function(){
    Route::get('/home-aluno', [\App\Http\Controllers\AlunoController::class, 'index'])->name('home-aluno')->middleware('CheckAluno');
    Route::get('/home-aluno',[\App\Http\Controllers\AlunoController::class, 'homeAluno'])->name('home-aluno')->middleware('CheckAluno');
    Route::get('/listar-requisicoes-aluno',[\App\Http\Controllers\AlunoController::class, 'listarRequisicoes'])->name('listar-requisicoes-aluno')->middleware('CheckAluno');
    Route::post('/confirmacao-requisicao', [\App\Http\Controllers\RequisicaoController::class, 'novaRequisicao'])->name('confirmacao-requisicao')->middleware('CheckAluno'); //------------
    Route::post('/finaliza-requisicao', [\App\Http\Controllers\RequisicaoController::class, 'finalizaRequisicao'])->name('finaliza-requisicao')->middleware('CheckAluno');
    Route::get('/cancela-requisicao', [\App\Http\Controllers\RequisicaoController::class, 'cancelaRequisicao'])->name('cancela-requisicao')->middleware('CheckAluno');
    Route::get('/prepara-requisicao', [\App\Http\Controllers\RequisicaoController::class, 'preparaNovaRequisicao'])->name('prepara-requisicao')->middleware('CheckAluno');
    Route::get('/prepara-requisicao-bibli', [\App\Http\Controllers\RequisicaoController::class, 'preparaNovaRequisicaoBibli'])->name('prepara-requisicao-bibli');
    Route::post('/excluir-requisicao/{id}',[\App\Http\Controllers\RequisicaoController::class, 'excluirRequisicao'])->name('excluir-requisicao');

    Route::post('/cadastrar-documento-bibli', [\App\Http\Controllers\RequisicaoController::class, 'cadastrarDocumento'])->name('cadastrarDocumento');
    Route::post('/criar-doc-bibli', [\App\Http\Controllers\RequisicaoController::class, 'criarDocumento'])->name('criarDocumentoBibli');
    Route::post('/criar-nada-consta', [\App\Http\Controllers\RequisicaoController::class, 'criarNadaConsta'])->name('criarNadaConsta');
    Route::post('/criar-deposito', [\App\Http\Controllers\RequisicaoController::class, 'criarDeposito'])->name('criarDeposito');

    Route::get('/confirmacao-requisicao',function(){
        return view('autenticacao.confirmacao-requisicao');
    })->name('confirmacao-requisicao')->middleware('CheckAluno');
    Route::get('/perfil-aluno',[\App\Http\Controllers\PerfilAlunoController::class, 'index'])->name('perfil-aluno')->middleware('CheckAluno');
    Route::get('/editar-perfil',[\App\Http\Controllers\PerfilAlunoController::class, 'editarInfo'])->name('editar-info')->middleware('CheckAluno');
    Route::get('/exibir-perfil-aluno',[\App\Http\Controllers\PerfilAlunoController::class, 'editarInfo'])->name('exibir-perfil-aluno')->middleware('CheckAluno');
    Route::post('/editar-perfil',[\App\Http\Controllers\PerfilAlunoController::class, 'storeEditarInfo'])->name('editar-info')->middleware('CheckAluno');
    Route::post('/excluir-perfil{idPerfil?}',[\App\Http\Controllers\PerfilAlunoController::class, 'excluirPerfil'])->name('excluir-perfil')->middleware('CheckAluno');
    Route::post('/perfil-padrao{idPerfilPadrao?}',[\App\Http\Controllers\PerfilAlunoController::class, 'definirPerfilDefault'])->name('perfil-padrao')->middleware('CheckAluno');
    Route::get('/adiciona-perfil', [\App\Http\Controllers\PerfilAlunoController::class, 'adicionaPerfil'])->name('adiciona-perfil')->middleware('CheckAluno');
    Route::post('/salva-novo-perfil-aluno', [\App\Http\Controllers\PerfilAlunoController::class, 'salvaPerfil'])->name('salva-novo-perfil-aluno')->middleware('CheckAluno');
    Route::post('/salva-novo-perfil-aluno', [\App\Http\Controllers\PerfilAlunoController::class, 'salvaPerfil'])->name('salva-novo-perfil-aluno')->middleware('CheckAluno');
    Route::get('/alterar-senha',[\App\Http\Controllers\PerfilAlunoController::class, 'alterarSenha'])->name('alterar-senha')->middleware('CheckAluno');
    Route::post('/alterar-senha',[\App\Http\Controllers\PerfilAlunoController::class, 'storeAlterarSenha'])->name('alterar-senha')->middleware('CheckAluno');
    Route::get('/formulario-requisicao',[\App\Http\Controllers\RequisicaoController::class, 'index'])->name('formulario-requisicao')->middleware('CheckAluno');
    Route::post('/formulario-requisicao',[\App\Http\Controllers\RequisicaoController::class, 'storeRequisicao'])->name('formulario-requisicao-post')->middleware('CheckAluno');
    Route::get('aluno/{requisicao_id}/gerar-ficha',[\App\Http\Controllers\BibliotecarioController::class, 'gerarFicha'])->name('gerar-ficha-aluno')->middleware('CheckFichaAluno');

    Route::get('/baixar-nada-consta/{requisicao_documento}', [\App\Http\Controllers\BibliotecarioController::class, 'baixarNadaConsta'])->name('baixar-nada-consta-aluno');
    Route::get('/baixar-deposito/{requisicao_documento}', [\App\Http\Controllers\BibliotecarioController::class, 'baixarDeposito'])->name('baixar-deposito-aluno');
    Route::get('/baixar-retificacao/{retificacao}', [\App\Http\Controllers\BibliotecarioController::class, 'baixarRetificacao'])->name('baixar-retificacao-aluno');
});

//----------------------------------------------BIBLIOTECARIO---------------------------------------------------
// Route::group(['middleware'=> 'verified'], function(){
Route::group(['middleware'=> ['CheckBibliotecario', 'banned']], function(){
    Route::get('/home-bibliotecario', [\App\Http\Controllers\BibliotecarioController::class, 'index'])->name('home-bibliotecario')->middleware('CheckBibliotecario');
    Route::get('/perfil-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class, 'perfil'])->name('perfil-bibliotecario')->middleware('CheckBibliotecario');
    Route::get('/editar-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class, 'editarBibliotecario'])->name('editar-bibliotecario')->middleware('CheckBibliotecario');
    Route::post('/atualizar-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class, 'atualizarBibliotecario'])->name('atualizar-bibliotecario')->middleware('CheckBibliotecario');
    Route::get('/editar-senha-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class, 'editarSenha'])->name('editar-senha-bibliotecario')->middleware('CheckBibliotecario');
    Route::post('/atualizar-senha-bibliotecario',[\App\Http\Controllers\BibliotecarioController::class, 'atualizarSenha'])->name('atualizar-senha-bibliotecario')->middleware('CheckBibliotecario');
    Route::get('/listar-fichas',[\App\Http\Controllers\BibliotecarioController::class, 'listarSolicitacoes'])->name('listar-fichas');
    Route::get('/visualizar-ficha/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'visualizarFicha'])->name('visualizar-ficha')->middleware('CheckBibliotecario');

    Route::get('/editar-ficha/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'editarFicha'])->name('editar-ficha')->middleware('CheckBibliotecario');
    Route::post('/atualizar-ficha',[\App\Http\Controllers\BibliotecarioController::class, 'atualizarFicha'])->name('atualizar-ficha')->middleware('CheckBibliotecario');
    Route::get('/editar-ficha/{requisicao_id}/rejeitar',[\App\Http\Controllers\BibliotecarioController::class, 'rejeitarFicha'])->name('rejeitar-ficha')->middleware('CheckBibliotecario');
    Route::post('/editar-ficha/{requisicao_id}/rejeitar-ficha',[\App\Http\Controllers\BibliotecarioController::class, 'atualizarRejeicao'])->name('atualizar-rejeicao')->middleware('CheckBibliotecario');
    Route::get('/editar-ficha/{requisicao_id}/gerar-ficha',[\App\Http\Controllers\BibliotecarioController::class, 'gerarFicha'])->name('gerar-ficha');
    Route::get('/editar-ficha/{requisicao_id}/baixarAnexo',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexo'])->name('baixar-anexo');
    Route::post('/preview/{requisicao_id}', [\App\Http\Controllers\BibliotecarioController::class, 'previewFicha'])->name('preview');

    Route::get('/avaliar-nada-consta/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'avaliarNadaConsta'])->name('avaliar-nada-consta')->middleware('CheckBibliotecario');
    Route::get('/avaliar-nada-consta/{requisicao_id}/baixarAnexoComprovante',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoComprovante'])->name('baixa-anexo-comprovante');
    Route::get('/avaliar-nada-consta/{requisicao_id}/baixarAnexoTermoAceitacao',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoTermoAceitacao'])->name('baixar-anexo-termo-aceitacao');
    Route::get('/visualizar-nada-consta/{retificacao}/baixarAnexoRetificacao',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoRetificacao'])->name('baixar-anexo-retificacao');
    Route::post('/deferir-nada-consta',[\App\Http\Controllers\BibliotecarioController::class, 'deferirNadaConsta'])->name('deferir-nada-consta')->middleware('CheckBibliotecario');
    Route::post('/indeferir-nada-consta',[\App\Http\Controllers\BibliotecarioController::class, 'indeferirNadaConsta'])->name('indeferir-nada-consta')->middleware('CheckBibliotecario');
    Route::post('/retificar-requisicao-documento',[\App\Http\Controllers\BibliotecarioController::class, 'retificarRequisicaoDocumento'])->name('retificar-requisicao-documento')->middleware('CheckBibliotecario');
    Route::get('/visualizar-nada-consta/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'visualizarNadaConsta'])->name('visualizar-nada-consta')->middleware('CheckBibliotecario');
    Route::post('/gerar-nada-consta/{requisicao_documento}',[\App\Http\Controllers\BibliotecarioController::class, 'gerarNadaConsta'])->name('gerar-nada-consta')->middleware('CheckBibliotecario');

    Route::get('/avaliar-deposito/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'avaliarDeposito'])->name('avaliar-deposito');
    Route::get('/visualizar-deposito/{requisicao_id}',[\App\Http\Controllers\BibliotecarioController::class, 'visualizarDeposito'])->name('visualizar-deposito');
    Route::get('/visualizar-deposito/{requisicao}/baixar-comprovante',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoComprovanteDeposito'])->name('baixar-anexo-comprovante-deposito');
    Route::get('/baixar-anexo-tcc-deposito/{requisicao}',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoTccDeposito'])->name('baixar-anexo-tcc-deposito');
    Route::get('/baixar-anexo-autorizacao-deposito/{requisicao}',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoAutorizacaoDeposito'])->name('baixar-anexo-autorizacao-deposito');
    Route::get('/baixar-anexo_publicacao_parcial/{requisicao}',[\App\Http\Controllers\BibliotecarioController::class, 'baixarAnexoPublicacaoParcial'])->name('baixar-anexo_publicacao_parcial');
    Route::post('/deferir-deposito',[\App\Http\Controllers\BibliotecarioController::class, 'deferirDeposito'])->name('deferir-deposito');
    Route::post('/indeferir-deposito',[\App\Http\Controllers\BibliotecarioController::class, 'indeferirDeposito'])->name('indeferir-deposito');
    Route::post('/gerar-deposito/{requisicao_documento}',[\App\Http\Controllers\BibliotecarioController::class, 'gerarDeposito'])->name('gerar-deposito');
});

// ---------------------------------------REQUISICAO------------------------------------------------------------------
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
// Route::get('/mail-send', 'MailController@send');

// Route::get('/edita-perfil','PerfilController@editaPerfil')->name('edita-perfil');
// Route::get('/adiciona-perfil', 'PerfilController@adicionaPerfil')->name('adiciona-perfil');//SUPRIMIR
// Route::post('/excluir-perfil',[\App\Http\Controllers\PerfilAlunoController::class, 'excluirPerfil')->name('excluir-perfil');
// Route::get('/', 'UsuarioController@index')->name('login');
// Route::post('/confirmacao-requisicao', [\App\Http\Controllers\AlunoController::class, 'novaRequisicao')->name('confirmacao-requisicao'); //------------
// Route::post('/finaliza-requisicao', [\App\Http\Controllers\AlunoController::class, 'finalizaRequisicao')->name('finaliza-requisicao');
// Route::get('/cancela-requisicao', [\App\Http\Controllers\AlunoController::class, 'cancelaRequisicao')->name('cancela-requisicao');
// Route::get('/prepara-requisicao', [\App\Http\Controllers\AlunoController::class, 'preparaNovaRequisicao')->name('prepara-requisicao');
// Route::post('/excluir-perfil',[\App\Http\Controllers\PerfilAlunoController::class, 'excluirPerfil')->name('excluir-perfil');

