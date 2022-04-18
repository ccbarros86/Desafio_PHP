<?php
namespace ASPTest\Command;
use PDO;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUsrPwdCommandTest extends Command
{
    protected function configure()
    {
        $this->setName('USER:CREATE-PWD-TEST');
        $this->setDescription('Cria a senha de um usuário existente');
        $this->addArgument('ID', InputArgument::REQUIRED, 'ID do usuário');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        
        $id = $input->getArgument('ID');
        //$sql = "SELECT * FROM usuarios WHERE id = " . $id;
        //$result = ConnectPDO($sql);
        //$sth = $result->fetch(PDO::FETCH_ASSOC);
        //(!$sth)?($userexists=FALSE):($userexists=TRUE);

        $userexists = TRUE; //Teste
        if($userexists){
            //$output->writeln('Cadastro de nova senha para o usuario ' . $sth['id'] . ":" . $sth['nome']);
            $output->writeln('Cadastro de nova senha para o usuario ' . $id . ":Carlos");
            $output->writeln('Requisitos:');
            $output->writeln('..................................');

            do
            {
                $output->writeln('Deve possui ao menos 6 caracteres;');
                $output->writeln('Deve possui ao menos 1 caracter especial;');
                $output->writeln('Deve possui ao menos 1 número;');
                $output->writeln('Deve possui ao menos 1 letra maiúscula.');
                $output->writeln('..................................');
                $pw = 'Teste@12';
                $output->write('Digite sua nova senha: ');
                $output->writeln($pw);
                //$question = new Question('Digite sua nova senha: ', '');
                //$pw = $helper->ask($input, $output, $question);
                $pwchk = 'Teste@12';
                $output->write('Confirme sua nova senha: ');
                $output->writeln($pwchk);
                //$question = new Question('Confirme sua nova senha: ', '');
                //$pwchk = $helper->ask($input, $output, $question);
                $pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[`~!@#$%^&*()_\-+={}\[\]\\\|:;\"\'<>,\.\?\/]).\S{5,36}$/';
                (!preg_match($pattern, $pw))?($err=TRUE):($err=FALSE);
                ($err)?($output->writeln('...... ERRO: Favor seguir os requisitos para a senha!')):(null);
                ($pw != $pwchk)?($errchk=TRUE):($errchk=FALSE);
                ($errchk)?($output->writeln('...... ERRO: As senhas não conferem!')):(null);
            } while($err || $errchk);
            
            $options = [
                'cost' => 10
            ];
            $encpw = password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);

            $output->writeln('...');
            $output->writeln('TESTE DE VALIDAÇÃO DE SENHA: OK');

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

            //$output->writeln('Nova senha gravada com sucesso');
        } else {
            //$output->writeln('...... ERRO: Usuário não encontrado!');
        }

        return 0;
    }
}