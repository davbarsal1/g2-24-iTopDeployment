<?php
/**
 * @copyright   Copyright (C) 2010-2021 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */


namespace Combodo\iTop\Application\UI\Base\Layout\Dashboard;

use Combodo\iTop\Application\UI\Base\Layout\UIContentBlock;
use Combodo\iTop\Application\UI\Base\UIBlock;

class DashboardLayout extends UIBlock
{
	public const BLOCK_CODE = 'ibo-dashboard';
	public const DEFAULT_HTML_TEMPLATE_REL_PATH = 'base/layouts/dashboard/layout';

	/** @var string */
	protected $sTitle;
	/** @var \Combodo\iTop\Application\UI\Base\Layout\UIContentBlock */
	protected $oToolbar;
	/** @var DashboardRow[] */
	protected $aDashboardRows;
	/** @var int */
	protected $iRows;

	public function __construct(?string $sId = null)
	{
		parent::__construct($sId);
		$this->aDashboardRows = [];
		$this->iRows = 0;
		$this->sTitle = '';
		$this->oToolbar = new UIContentBlock(null, ['ibo-dashboard--top-bar-toolbar']);
	}

	/**
	 *
	 * @param \Combodo\iTop\Application\UI\Base\Layout\Dashboard\DashboardRow $oDashboardRow
	 *
	 * @return $this
	 */
	public function AddDashboardRow(DashboardRow $oDashboardRow)
	{
		$oDashboardRow->SetRowIndex($this->iRows);
		$this->aDashboardRows[] = $oDashboardRow;
		$this->iRows++;

		return $this;
	}

	public function GetSubBlocks()
	{
		return array_merge($this->aDashboardRows, [$this->oToolbar]);
	}

	/**
	 * @return string
	 */
	public function GetTitle(): string
	{
		return $this->sTitle;
	}

	/**
	 * @return \Combodo\iTop\Application\UI\Base\Layout\UIContentBlock
	 */
	public function GetToolbar()
	{
		return $this->oToolbar;
	}

	public function SetTitle(string $sTitle)
	{
		$this->sTitle = $sTitle;
	}

	/**
	 * @return \Combodo\iTop\Application\UI\Base\Layout\Dashboard\DashboardRow[]
	 */
	public function GetDashboardRows(): array
	{
		return $this->aDashboardRows;
	}
}