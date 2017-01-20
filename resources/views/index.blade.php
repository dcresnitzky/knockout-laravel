<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Desafio Lux</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset("css/materialize.min.css") }}"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Style -->
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
</head>

<body>
    <header>
        <!-- Menu -->
        <nav class="lighten-1 blue accent-1" role="navigation">
            <div class="nav-wrapper container">
                <ul class="left" data-bind="foreach: menu">
                    <li data-bind="css: { active: $data == $root.chosenMenuId() }"><a href="!#" data-bind="text: $data,
                    click: $root.goTo"></a></li>
                </ul>
                <ul class="left">
                    <li>
                        <a class="switch " >
                            <span class="hide-on-med-and-down">Exibir indisponíveis</span>
                        <!-- Switch -->
                            <label>
                                <input type="checkbox" checked  data-bind="click: $root.toggleExibeSemEstoque ">
                                <span class="lever"></span>
                            </label>
                        </a>
                    </li>
                    <li><a href="!#" data-bind="click: $root.atualiza"><i class="material-icons">refresh</i></a></li>
                </ul>

            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <!-- Cadastro -->
            <form class="valign" data-bind="visible: chosenMenuId() == 'Cadastrar Novo'">
                <h5 class="flow-text">Utilize o formulário abaixo para cadastrar novos produtos.<br>
                    <small>Os campos "Preço" e "Estoque" devem ser numéricos.</small></h5>
                <div class="input-field">
                    <input id="nome" type="text" class="validate" required data-bind="value: nome"/>
                    <label for="nome" data-error="Insira um nome" >Nome</label>
                </div>
                <div class="input-field">
                    <input id="preco" type="number" step="0.01" class="validate" required data-bind="value: preco"/>
                    <label for="preco" data-error="Deve ser um valor numérico" >Preço</label>
                </div>
                <div class="input-field">
                    <input id="estoque" type="number" step="0.01" class="validate" required data-bind="value: estoque"/>
                    <label for="estoque" data-error="Deve ser um valor numérico" >Estoque Inicial</label>
                </div>
                <a class="waves-effect waves-light btn" data-bind="click: $root.novoProduto"><i class="material-icons left">save</i>Adicionar</a>
            </form>
            <!-- Produtos -->
            <div id="produtos" data-bind="visible: $root.chosenMenuId() != 'Cadastrar Novo'">
                <h5 class="flow-text">Clique sobre os cabeçalhos da tabela para odernar os produtos.<br>
                    <small>Utilize o botão liga/desliga acima para exibir os produtos sem estoque</small></h5>
                <table class="striped">
                    <thead>
                    <tr>
                        <th data-bind="click: $root.filtraNome" style="width:50%">
                            Nome
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'nome_desc' ">arrow_drop_up</i>
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'nome_asc' ">arrow_drop_down</i>
                        </th>
                        <th data-bind="click: $root.filtraPreco" style="width:10%">
                            Preço
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'preco_desc' ">arrow_drop_up</i>
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'preco_asc' ">arrow_drop_down</i>
                        </th>
                        <th data-bind="click: $root.filtraEstoque"  >
                            Estoque atual
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'estoque_desc' ">arrow_drop_up</i>
                            <i class="material-icons" data-bind="visible: $root.filtroAtual() == 'estoque_asc' ">arrow_drop_down</i>
                        </th>
                        <th style="width:1%"></th>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: produtos">
                    <tr data-bind="visible: estoque() > 0 || $root.exibeSemEstoque() ">
                        <td data-bind="text: nome"></td>
                        <td>R$ <span data-bind="text: preco"></span></td>
                        <td>
                            <a href="#" data-activates="nav-mobile" class="btn-floating btn waves-effect waves-light" data-bind="click: decrementaEstoque, css: { disabled: !estoque() }">-</a>
                            <span class="estoque" data-bind="text: estoque"></span>
                            <a href="#" data-activates="nav-mobile" class="btn-floating btn waves-effect waves-light" data-bind="click: incrementaEstoque">+</a>
                        </td>
                        <td>
                            <a href="#" data-activates="nav-mobile" class="waves-effect waves-light btn-floating btn right" data-bind="click: $root.removeProduto"><i class="material-icons left">delete</i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="blue accent-2">
            <div class="container  white-text">
                Feito por <a class="text-lighten-3 white-text" href="mailto:dcresnitzky@gmail.com">Daniel Costa Resnitzky</a>
            </div>
    </footer>

    <div id="modal_remove" class="modal">
        <div class="modal-content">
            <h4>Por favor confirme</h4>
            <p>Tem certeza que deseja deletar o produto?</p>
        </div>
        <div class="modal-footer ">
            <a href="#" class="waves-effect waves-red btn-flat" onclick="$('#modal_remove').modal('close'); return false;">Cancelar</a>
            <a href="#" class="waves-effect waves-green btn-flat" id="modal_remove_sim">Sim</a>
        </div>
    </div>
</body>

<!-- jQuery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Knockout -->
<script type="text/javascript" src="{{ asset("js/knockout-3.4.1.js") }}"></script>
<!-- Materialize -->
<script type="text/javascript" src="{{ asset("js/materialize.min.js") }}"></script>
<!-- App -->
<script type="text/javascript" src="{{ asset("js/app.js") }}"></script>
<script>
    $(document).ready(function(){
// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('#modal_remove').modal();
    });
</script>
</html>
