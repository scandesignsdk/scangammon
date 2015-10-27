<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('player1', 'player_selector', [
                'invalid_message' => 'Player 1 not found',
                'label' => 'Player 1 ID',
            ])
            ->add('player2', 'player_selector', [
                'invalid_message' => 'Player 2 not found',
                'label' => 'Player 2 ID',
            ])
            ->add('winner', 'integer', [
                'label' => 'Winner - 1 = player 1, 2 = player 2',
            ])
            ->add('wintype', 'integer', [
                'label' => 'Win type - 0 = normal, 1 = gammon, 2 = backgammon'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Game'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'game_form';
    }
}
