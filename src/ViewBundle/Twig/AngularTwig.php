<?php
namespace ViewBundle\Twig;

use AppBundle\Entity\Game;

class AngularTwig extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ng', [$this, 'getNgVariable']),
            new \Twig_SimpleFunction('player', [$this, 'getPlayerFunctionHtml'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('game', [$this, 'getGameFunctionHtml'], ['is_safe' => ['html']])
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('player', [$this, 'getPlayerHtml'], ['is_safe' => ['html']])
        ];
    }

    public function getGameFunctionHtml($player1_name, $player1_elo, $player2_name, $player2_elo, $winner, $date)
    {
        return sprintf(
            '%s, %s - %s <span class="date" data-date="%s"></span> %s (%s)',
            $player1_name == '1' ? 'Yip' : 'NOO',
            $this->getPlayerFunctionHtml($player1_name, $player1_elo, $winner == 1),
            $this->getPlayerFunctionHtml($player2_name, $player2_elo, $winner == 2),
            $date,
            trim($winner) == 2 ? 'YES' : 'NO',
            $winner
        );
    }

    public function getPlayerFunctionHtml($name, $elo, $isBold = true)
    {
        return sprintf('%s%s <span class="badge">%s</span>%s', $isBold ? '<b>' : '', $name, $elo, $isBold ? '</b>' : '');
    }

    public function getPlayerHtml($data)
    {
        return $this->getPlayerFunctionHtml($data['name'], $data['elo']);
    }

    public function getNgVariable($variable)
    {
        return '{{ ' . $variable . ' }}';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'angular-twig';
    }
}
