<?php
declare(strict_types=1);

namespace Wolfpup\SbazarScraper\Commands;

use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Wolfpup\SbazarScraper\Entities\Item;


class ScrapeCommand extends Command
{

	const BASE_URL = 'https://www.sbazar.cz/628-kola/cela-cr/cena-neomezena/nejnovejsi';
	const ITEM_SELECTOR = '.c-item .c-item__group';
	const ATTRS_SELECTOR = '.c-item__attrs';
	const NAME_SELECTOR = '.c-item__name-text';
	const PRICE_SELECTOR = '.c-price__price';
	const LOCATION_SELECTOR = '.c-item__locality';

	protected static $defaultName = 'scrape';

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$client = new Client();
		$crawler = $client->request('GET', self::BASE_URL);

		$i = 0;

		$crawler->filter(self::ITEM_SELECTOR)->each(function (Crawler $node) use ($output, &$i) {
			$attrs = $node->children()->first()->siblings()->filter(self::ATTRS_SELECTOR);

			$item = (new Item)
				->setName($node->filter(self::NAME_SELECTOR)->extract(['_text'])[0])
				->setPriceParsed($attrs->filter(self::PRICE_SELECTOR)->extract(['_text'])[0])
				->setLocation($attrs->filter(self::LOCATION_SELECTOR)->extract(['_text'])[0])
				->setLink($node->filter('a')->extract(['href'])[0]);

			$output->writeln("\n" . ++$i);
			$output->writeln($item->getName());
			$output->writeln((string) $item->getPrice());
			$output->writeln($item->getLocation() ?? 'not found');
			$output->writeln($item->getLink() ?? 'not found');
			$output->writeln($item->getHash());
		});

		return 0;
	}

}
