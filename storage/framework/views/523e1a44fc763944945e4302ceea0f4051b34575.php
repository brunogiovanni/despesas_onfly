<div>
    <strong>Descrição: </strong>
    <p>
        <?php echo e($descricao); ?>

    </p>
    <strong>Valor: </strong> R$ <?php echo e(number_format($valor, 2, ',', '.')); ?>

    <br />
    <strong>Data: </strong> <?php echo e($data); ?>

</div><?php /**PATH /var/www/html/resources/views/despesa/mail.blade.php ENDPATH**/ ?>