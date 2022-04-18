<?php
namespace ASPTest\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUsrCommandTest extends Command
{
    public function configure()
    {
        $this->setName('USER:CREATE-TEST');
        $this->setDescription('Cria um usuário');
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        
        $output->writeln('Criando novo usuário. Por favor, digite os dados a seguir:');
        $output->writeln('......................');

        do
        {
            $nome = 'Carlos';
            $output->write('Primeiro nome: ');
            $output->writeln($nome);
            //$question = new Question('Primeiro nome: ', '');
            //$nome = $helper->ask($input, $output, $question);
            (strlen($nome)<2 || strlen($nome)>35)?($err=TRUE):($err=FALSE);
            ($err)?($output->writeln('...... ERRO: Favor digitar um NOME entre 2 e 35 caracteres!')):(null);
        } while($err);
        
        do
        {
            $sobrenome = 'Barros';
            $output->write('Sobrenome: ');
            $output->writeln($sobrenome);
            //$question = new Question('Sobrenome: ', '');
            //$sobrenome = $helper->ask($input, $output, $question);
            (strlen($sobrenome)<2 || strlen($sobrenome)>35)?($err=TRUE):($err=FALSE);
            ($err)?($output->writeln('...... ERRO: Favor digitar um SOBRENOME entre 2 e 35 caracteres!')):(null);
        } while($err);
        
        do
        {
            $email = 'carlos@barros.com.pt';
            $output->write('Endereço de email válido: ');
            $output->writeln($email);
            //$question = new Question('Endereço de email válido: ', '');
            //$email = $helper->ask($input, $output, $question);
            (!filter_var($email, FILTER_VALIDATE_EMAIL))?($err=TRUE):($err=FALSE);
            ($err)?($output->writeln('...... ERRO: Favor digitar um EMAIL válido!')):(null);
        } while($err);
        
        do
        {
            $idade = '35';
            $output->write('Idade: ');
            $output->writeln($idade);
            //$question = new Question('Idade: ', '');
            //$idade = $helper->ask($input, $output, $question);
            ($idade != '' && (!is_numeric($idade) || strlen($idade)>4 || (float)$idade<1 || (float)$idade>150))?($err=TRUE):($err=FALSE);
            ($err)?($output->writeln('...... ERRO: Favor digitar uma IDADE entre 1 e 150 anos com no máximo 4 caracteres ou deixar vazio!')):(null);
        } while($err);
        ($idade == '')?($idade = null):(null);

        $usuario = 
        [
            'usuario' => 
            [
                'nome' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'idade' => $idade
            ]
        ];
        
        $json_usuario = json_encode($usuario);
        $output->writeln($json_usuario);

        $output->writeln('...');
        $output->writeln('TESTE DE VALIDAÇÃO DE CAMPOS: OK');

        $sql = "SELECT * FROM usuarios";
        try{
            ConnectPDO($sql);
            $output->writeln('...');
            $output->writeln('TESTE DE CONEXÃO SQL: OK');
        }
        catch(Exception $e) {
            $output->writeln('...');
            $output->writeln('TESTE DE CONEXÃO SQL: ' .$e->getMessage());
        }

        return 0;
    }
}