<?php
namespace ASPTest\Command;
use PDO;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUsrPwdCommand extends Command
{
    protected function configure()
    {
        $this->setName('USER:CREATE-PWD');
        $this->setDescription('Cria a senha de um usuário existente');
        $this->addArgument('ID', InputArgument::REQUIRED, 'ID do usuário');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        
        $id = $input->getArgument('ID');
        $sql = "SELECT * FROM usuarios WHERE id = " . $id;
        $result = ConnectPDO($sql);
        $sth = $result->fetch(PDO::FETCH_ASSOC);
        (!$sth)?($userexists=FALSE):($userexists=TRUE);

        if($userexists){
            $output->writeln('Cadastro de nova senha para o usuario ' . $sth['id'] . ":" . $sth['nome']);
            $output->writeln('Requisitos:');
            $output->writeln('..................................');

            do
            {
                $output->writeln('Deve possui ao menos 6 caracteres;');
                $output->writeln('Deve possui ao menos 1 caracter especial;');
                $output->writeln('Deve possui ao menos 1 número;');
                $output->writeln('Deve possui ao menos 1 letra maiúscula.');
                $output->writeln('..................................');
                $question = new Question('Digite sua nova senha: ', '');
                $pw = $helper->ask($input, $output, $question);
                $question = new Question('Confirme sua nova senha: ', '');
                $pwchk = $helper->ask($input, $output, $question);
                $pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[`~!@#$%^&*()_\-+={}\[\]\\\|:;\"\'<>,\.\?\/]).\S{5,36}$/';
                (!preg_match($pattern, $pw))?($err=TRUE):($err=FALSE);
                ($err)?($output->writeln('...... ERRO: Favor seguir os requisitos para a senha!')):(null);
                ($pw != $pwchk)?($errchk=TRUE):($errchk=FALSE);
                ($errchk)?($output->writeln('...... ERRO: As senhas não conferem!')):(null);
            } while($err || $errchk);
            
            $options = [
                'cost' => 10
            ];
            $encpw = password_hash($pw, PASSWORD_BCRYPT, $options);
            $sql = "UPDATE usuarios SET pw = '" . $encpw . "' WHERE id = " . $id;
            ConnectPDO($sql);
            $output->writeln('Nova senha gravada com sucesso');
        } else {
            $output->writeln('...... ERRO: Usuário não encontrado!');
        }

        return 0;
    }
}