<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Psrphp;

use App\Psrphp\Admin\Model\MenuProvider;
use App\Psrphp\Section\Http\Index;
use PsrPHP\Framework\Framework;
use PsrPHP\Psr11\Container;
use PsrPHP\Template\Template;
use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    public function getListenersForEvent(object $event): iterable
    {
        if (is_a($event, Container::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    Container $container
                ) {
                    $container->set(Template::class, function (
                        Template $template
                    ) {
                        $template->extend('/\{section\s*([a-zA-Z0-9_]+)\s*\}/Ui', function ($matchs) {
                            return '<?php echo \App\Psrphp\Section\Model\Section::render(\'' . $matchs[1] . '\') ?>';
                        });
                        return $template;
                    });
                }, [
                    Container::class => $event,
                ]);
            };
        }
        if (is_a($event, MenuProvider::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    MenuProvider $provider
                ) {
                    $provider->add('区块管理', Index::class);
                }, [
                    MenuProvider::class => $event,
                ]);
            };
        }
    }
}
