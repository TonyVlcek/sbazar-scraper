<?php
declare(strict_types=1);

namespace Wolfpup\SbazarScraper\Entities;


class Item
{

	/** @var string */
	private $name;

	/** @var float - rounded */
	private $price;

	/** @var string|null */
	private $location;

	/** @var string|null */
	private $link;

	/** @var string|null */
	private $description;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Item
	 */
	public function setName(string $name): Item
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 * @return Item
	 */
	public function setPrice(float $price): Item
	{
		$this->price = round($price, 2);

		return $this;
	}

	public function setPriceParsed(string $price): Item
	{
		$price = floatval(preg_replace('/\xc2\xa0/', '', $price));

		return $this->setPrice($price);
	}

	/**
	 * @return null|string
	 */
	public function getLocation(): ?string
	{
		return $this->location;
	}

	/**
	 * @param null|string $location
	 * @return Item
	 */
	public function setLocation(?string $location): Item
	{
		$this->location = $location;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getLink(): ?string
	{
		return $this->link;
	}

	/**
	 * @param null|string $link
	 * @return Item
	 */
	public function setLink(?string $link): Item
	{
		$this->link = $link;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param null|string $description
	 * @return Item
	 */
	public function setDescription(?string $description): Item
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHash()
	{
		return sha1($this->getName().$this->getPrice().$this->getLink());
	}

}
