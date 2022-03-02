<div>
    <strong>Descrição: </strong>
    <p>
        {{ $descricao }}
    </p>
    <strong>Valor: </strong> R$ {{ number_format($valor, 2, ',', '.') }}
    <br />
    <strong>Data: </strong> {{ $data }}
</div>