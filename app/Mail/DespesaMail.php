<?php

namespace App\Mail;

use App\Models\Despesa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DespesaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Despesa $despesa
    ) {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('no-reply@onfly.com.br', 'Despesas OnFly')
            ->subject('Despesa cadastrada')
            ->view('despesa.mail')
            ->with([
                'descricao' => $this->despesa->descricao,
                'valor' => $this->despesa->valor,
                'data' => date('d/m/Y', strtotime($this->despesa->data)),
            ]);
    }
}
