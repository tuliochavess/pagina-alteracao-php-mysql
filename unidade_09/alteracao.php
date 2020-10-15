<?php require_once("../../conexao/conexao.php"); ?>
<?php
    
    if (isset($_POST["nometransportadora"])) {
        $nome       = $_POST["nometransportadora"];
        $endereco   = $_POST["endereco"];
        $telefone   = $_POST["telefone"];
        $cidade     = $_POST["cidade"];
        $estado     = $_POST["estados"];
        $cep        = $_POST["cep"];
        $cnpj       = $_POST["cnpj"];
        $tID        = $_POST["transportadoraID"];

        $alterar = "UPDATE transportadoras ";
        $alterar .= " SET ";
        $alterar .= " nometransportadora = '{$nome}', ";
        $alterar .= " endereco = '{$endereco}', ";
        $alterar .= " telefone = '{$telefone}', ";
        $alterar .= " cidade = '{$cidade}', ";
        $alterar .= " estados = {$estado}, ";
        $alterar .= " cep = '{$cep}', ";
        $alterar .= " cnpj = '{$cnpj}', ";
        $alterar .= " WHERE transportadoraID = {$tID} ";

        $operacao_alterar = mysqli_query($conecta,$alterar);
        if (!$operacao_alterar) {
            die("Falha ao alterar o banco de dados");
        } else {
            header("location:listagem.php");
        };
    };

    $tr = "SELECT * ";
    $tr .= " FROM transportadoras ";
    
    if (isset($_GET["codigo"])) {
        $id = $_GET["codigo"];
        $tr .= " WHERE transportadoraID = {$id} ";
    } else {
        $tr .= " WHERE transportadoraID = 1 ";
    };

    $con_transportadora = mysqli_query($conecta,$tr);
    if (!$con_transportadora) {
        die("Falha na consulta ao banco de dados");
    };

    $info_transportadora = mysqli_fetch_assoc($con_transportadora);

    //print_r($info_transportadora);

    // consulta aos estados
    $estados = "SELECT * ";
    $estados .= " FROM estados ";
    $lista_estados = mysqli_query($conecta,$estados);
    if (!$lista_estados) {
        die("Falha ao consultar o banco de dados ESTADOS");
    };
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="janela_formulario">
                <form action="alteracao.php" type="post">
                    <h2>Alteração de Transportadoras</h2>

                    <label for="nometransportadora">Nome da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["nometransportadora"] ?>" name="nometransportadora" id="nometransportadora">

                    <label for="endereco">Endereço da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["endereco"] ?>" name="endereco" id="endereco">

                    <label for="telefone">Telefone da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["telefone"] ?>" name="telefone" id="telefone">

                    <label for="cidade">Cidade da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["cidade"] ?>" name="cidade" id="cidade">

                    <label for="estados">Estado da Transportadora</label>
                    <select id="estados" name="estados">
                        <?php 
                            $meuestado = $info_transportadora["estadoID"];
                            while ($linha = mysqli_fetch_assoc($lista_estados)) {
                                $estado_principal = $linha["estadoID"];
                                if ($meuestado == $estado_principal) {
                        ?>
                            <option value="<?php echo $linha["estadoID"] ?>" selected>
                                <?php echo $linha["nome"] ?>
                            </option>
                        <?php 
                                } else {
                        ?>
                            <option value="<?php echo $linha["estadoID"] ?>">
                                <?php echo $linha["nome"] ?>
                            </option>
                        <?php
                                }
                            };
                        ?>
                    </select>

                    <label for="cep">CEP da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["cep"] ?>" name="cep" id="cep">

                    <label for="cnpj">CNPJ da Transportadora</label>
                    <input type="text" value="<?php echo $info_transportadora["cnpj"] ?>" name="cnpj" id="cnpj">

                    <input type="hidden" name="transportadoraID" value="<?php echo $info_transportadora["transportadoraID"] ?>">            
                    <input type="submit" value="Confirmar alteração">
                </form>
            </div>
        </main>

        <?php include_once("../_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>