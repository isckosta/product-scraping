<?php

    namespace App\Http\Controllers;

    use App\Models\Product;
    use Goutte\Client;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class ProductController extends Controller
    {
        /*
         * O método index() retornará todos os produtos registrados no Banco de Dados, paginação está configurada
         * para exibir 10 elementos. */

        public function index()
        {
            return DB::table("products")->paginate(10);
        }

        /* O método sync() é utilizado para sincronizar manualmente os produtos do site OpenFoodFacts com o Banco de Dados. */
        public function sync()
        {
            // Inicia um novo cliente da instância do Goutte.
            $client = new Client();

            // URL redirecionada para o país Brazil, idioma Português.
            $url = "https://br.openfoodfacts.org";

            // Requisição para a URL raiz do site.
            $page = $client->request('GET', $url);

            /* Lista de nós (elementos) que o Goutte irá capturar ao fazer a requisição para a URL definida na variável $url. */
            $nodeList = $page->filter('#search_results')->filter('a')->each(function ($node){

                /* Para cadá nó encontrado, o Goutte fará uma nova requisição para o site, dessa vez para a URL do produto usando
                o atributo 'href' do elemento '<a></a>' encontrado, montando assim, a URL do produto. */
                $client = new Client();

                // URL redirecionada para o país Brasil, idioma Português.
                $newProductUrl = "https://br.openfoodfacts.org" . $node->attr('href');

                // Requisição para a URL do produto.
                $productPage = $client->request('GET', $newProductUrl);

                try {

                    // Nome do produto
                    $name = $productPage->filter('title')->text();

                    // Extração e formatação básica do nome do produto, retirando a marca e quantidade que constava no elemento "name".
                    $realProductName = ucwords(rtrim(explode(" -", $name, 2)[0]));

                    // Còdigo de barras do produto
                    $barcode = $productPage->filter('p')->filter('#barcode_paragraph')->text();

                    // Extração e formatação do código de barras do produto, deixando apenas os números do código de barras.
                    $realProductBarcode = explode(" ", $barcode, 5)[3];

                    // Quantidade registrada do produto
                    $quantity = $productPage->filter('p')->filter('#field_quantity_value')->text();

                    // Marcas registradas no produto
                    $brands = ucfirst($productPage->filter('p')->filter('#field_brands_value')->text());

                    // Tipo de embalagens registradas no produto.
                    $packaging = ucfirst($productPage->filter('p')->filter('#field_packaging_value')->text());

                    // Categorias registradas no produto.
                    $categories = $productPage->filter('p')->filter('#field_categories_value')->text();
                } catch (\Exception $e) {
                    /*
                     * O site OpenFoodFacts tem produtos que ainda não tem os atributos de quantidade, marcas,
                     * embalagens e categorias registradas. Por esse motivo, o sistema lançaria uma Exception
                     * e pararia o script.
                     *
                     * Para não ocorrer a paralização do script, as variáveis serão tratadas a partir daqui, apenas
                     * sendo substituídas por uma mensagem qualquer, para o banco de dados, ou poderiam ser simplismente
                     * uma string vazia, mas por questões de estética e compreensão achei válido colocar uma frase para
                     * indicar que o produto não os atributos abaixo registrados no site.
                     * */
                    $quantity = "Campo não preenchido.";
                    $brands = "Campo não preenchido.";
                    $packaging = "Campo não preenchido.";
                    $categories = "Campo não preenchido.";
                }

                $rawData = Product::create(["name" => $realProductName, "barcode" => $realProductBarcode, "quantity" => $quantity, "brands" => $brands, "packaging" => $packaging, "categories" => $categories, "imported_t" => now(), "status" => "imported"]);
                dd();
            });

            return "Produtos importados com sucesso!";

        }

        // Este método busca um produto pelo código de barras.
        public function findByBarCode(Request $request)
        {
            return Product::where('barcode', $request->barCode)->first();
        }
    }
