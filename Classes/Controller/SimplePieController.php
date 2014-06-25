<?php
namespace TYPO3\SimplepieRss\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package simplepie_rss
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SimplePieController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * simplePieRepository
	 *
	 * @var \TYPO3\SimplepieRss\Domain\Repository\SimplePieRepository
	 * @inject
	 */
	protected $simplePieRepository;


	protected function initializeAction() {
		if ( !is_dir($this->getCacheFolder()) ) {
			\TYPO3\CMS\Core\Utility\GeneralUtility::mkdir( $this->getCacheFolder() );
		}
	}


	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('simplepie_rss', 'Resources/Php/SimplePie-1.3.1/autoloader.php');

		$feed = new \SimplePie();
		$feed->enable_cache( true );
		$feed->set_cache_duration( 3600 );
		$feed->set_cache_location( $this->getCacheFolder() );
		// Set which feed to process.
		$feed->set_feed_url( $this->settings['feedUrl'] );
		$feed->enable_order_by_date( false );

		// Run SimplePie.
		$feed->init();

		// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
		$feed->handle_content_type();

		// if ($feed->error())
		// {
		// 	echo $feed->error();
		// }

		//setlocale (LC_TIME, 'de_DE');
		foreach ($feed->get_items(0, $this->settings['itemLimit']) as $item) {

            $markerArray = array(
                'date' => $item->get_local_date('%d.%m.%Y'),
                'title' => $this->cleanContent( html_entity_decode( $item->get_title() )) , 
				'text' => $this->cleanContent( $item->get_content() ),
				'link' => $item->get_permalink()
            );
            $items[] = $markerArray;
        }

		$this->view->assign('simplePies', $items);
	}



	private function getCacheFolder() {
		return PATH_site . 'typo3temp' . DIRECTORY_SEPARATOR . 'tx_simplepierss' . DIRECTORY_SEPARATOR;
	}
	
	public function cleanContent($string){
		//unicode Symbole wie '&#xfc;' ersetzen
		// html_entity_decode holft da nicht
			$replace = array (
				'&Uuml;'  => 'Ü',
				'&#xDC;'  => 'Ü',
				'&uuml;' =>  'ü',
				'&#xfc;' =>  'ü',
				'&Auml;'  => 'Ä',
				'&#xC4;'  => 'Ä',
				'&auml;'  => 'ä',
				'&#xE4;'  => 'ä',
				'&Ouml;' =>  'Ö',
				'&#xD6;' =>  'Ö',
				'&ouml;' =>  'ö',
				'&#xF6;' =>  'ö',
				'&szlig' => 'ß',
				'&#xDF;' => 'ß',
				'&#xdf;' => 'ß',
				'&#x2014;' => '—'
				
			);
			$text = strtr($text, $replace);


		return strtr($string, $replace);
		
	}

}
?>