// Classe para representar o produto
function Produto(id, nome, preco, estoque) {
    var self = this;

    self.id = id;
    self.nome = nome;
    self.preco = preco;
    self.estoqueOriginal = estoque;
    self.estoque = ko.observable(estoque);

    // Métodos
    self.incrementaEstoque = function(){
        self.estoque(++estoque);
        $.post("produtos/update",{id : id, estoque: estoque})
            .success(function() {
                //alert( "success" );
                Materialize.toast('Estoque aumentado',4000);
            })
            .fail(function() {
                self.estoque(--estoque);
                Materialize.toast('Erro ao aumentar',4000);
            });

    }
    self.decrementaEstoque = function(){
        if (estoque >= 1) {
            self.estoque(--estoque);
            $.post("produtos/update",{id : id, estoque: estoque})
                .success(function() {
                    Materialize.toast('Estoque reduzido',4000);
                })
                .fail(function() {
                    self.estoque(++estoque);
                    Materialize.toast('Erro ao reduzir',4000);
                });
        }
    }
}

function AppViewModel() {
    var self = this;

    // Menu
    self.menu = ['Listar Produtos', 'Cadastrar Novo'];
    self.chosenMenuId = ko.observable();
    // Comportamento do Menu
    self.goTo = function(menu) {
        self.chosenMenuId(menu);
    };
    // Mostra a lsita por padrão
    self.goTo('Listar Produtos');
    //Produtos
    self.produtos = ko.observableArray([]);
    //// Novo Produto
    self.nome = ko.observable();
    self.preco = ko.observable();
    self.estoque = ko.observable();
    self.novoProduto = function() {
        $.post("produtos",{nome: self.nome(), preco: self.preco(), estoque: self.estoque()})
            .success(function(data) {
                self.produtos.push(new Produto(data.id,data.nome,data.preco,data.estoque));
                Materialize.toast('Novo produto salvo',4000);
                self.chosenMenuId('Listar Produtos');
                self.nome('');
                self.preco('');
                self.estoque('');
            })
            .fail(function() {
                Materialize.toast('Erro ao salvar novo produto',4000);
            });
    }
    // Função para deletar o produto
    self.removeProduto = function(produto) {
        $('#modal_remove').modal('open');
        $('#modal_remove_sim').click(function() {
            $('#modal_remove').modal('close');
            $.get("produtos/remover/"+produto.id)
                .success(function(data) {
                    self.produtos.remove(produto);
                    Materialize.toast('Produto removido',4000);
                })
                .fail(function() {
                    Materialize.toast('Erro ao remover produto',4000);
                });
        });

    }
    // Filtro
    self.filtroAtual = ko.observable();
    self.filtra = ko.computed(function () {
        switch (self.filtroAtual()){
            case 'nome_asc':
                self.produtos(self.produtos().sort(function(a, b) { return a.nome > b.nome;}));
                break;
            case 'nome_desc':
                self.produtos(self.produtos().reverse());
                break;
            case 'preco_asc':
                self.produtos(self.produtos().sort(function(a, b) { return a.preco - b.preco;}));
                break;
            case 'preco_desc':
                self.produtos(self.produtos().reverse());
                break;
            case 'estoque_asc':
                self.produtos(self.produtos().sort(function(a, b) { return a.estoque() - b.estoque();}));
                break
            case 'estoque_desc':
                self.produtos(self.produtos().reverse());
                break;
            default:
                self.produtos(self.produtos().sort(function(a, b) { return a.id > b.id ;}));
                break;
        }
        self.produtos.valueHasMutated();
    }, self);

    self.filtraNome = function() {
        self.filtroAtual( self.filtroAtual() == 'nome_asc' ? 'nome_desc' : self.filtroAtual() == 'nome_desc' ? 'id' : 'nome_asc');
    }
    self.filtraPreco = function() {
        self.filtroAtual( self.filtroAtual() == 'preco_asc' ? 'preco_desc' : self.filtroAtual() == 'preco_desc' ? 'id' : 'preco_asc');
    }
    self.filtraEstoque = function() {
        self.filtroAtual( self.filtroAtual() == 'estoque_asc' ? 'estoque_desc' : self.filtroAtual() == 'estoque_desc' ? 'id' : 'estoque_asc');
    }
    self.exibeSemEstoque = ko.observable(true);
    self.toggleExibeSemEstoque = function() {
        self.exibeSemEstoque(!self.exibeSemEstoque());
        return true;
    }

    // Carrega a lista de produtos
    self.atualiza = function() {
        self.produtos([]);
        $.get("produtos")
            .success(function (data) {
                var mappedData = ko.utils.arrayMap(data, function (value) {
                    return new Produto(value.id, value.nome, value.preco, value.estoque);
                });
                self.produtos(mappedData);
                Materialize.toast('Produtos recebidos', 4000);
            })
            .fail(function () {
                Materialize.toast('Problemas ao se comunicar com o servidor', 4000);
            });
    };
    self.atualiza();
};
ko.applyBindings(new AppViewModel());