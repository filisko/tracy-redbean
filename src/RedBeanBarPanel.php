<?php
namespace Filisko\Tracy;

use \Tracy\Debugger;
use \Tracy\IBarPanel;

class RedBeanBarPanel implements \Tracy\IBarPanel
{
    /**
     * Base64 icon for Tracy panel.
     * @var string
     * @see http://www.flaticon.com/free-icon/coffee-bean_63156
     * @author Freepik.com
     * @license http://file000.flaticon.com/downloads/license/license.pdf
     */
    public static $icon = 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDUwMS43NTIgNTAxLjc1MiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTAxLjc1MiA1MDEuNzUyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQ0MC43MjMsMTg0LjA2MWMtODguMS05NC45LTI2NS42LTE3Mi0zOTYuNi0xNDQuNGMtOC42LDEuOC0xMi4yLDguNi0xMSwxNS4zYy04MS40LDQ0LjcsOC42LDE5OS41LDQyLjgsMjQ0LjggICBjNjcuMyw5MCwxODcuODk5LDE5MC44OTksMzA5LjEsMTYzLjM5OWM1NS43LTEyLjg5OSw5Ni43LTY1LjUsMTEyLTExOC4xQzUxNC43MjMsMjg1LjA2MSw0NzkuODIzLDIyNi4zNjEsNDQwLjcyMywxODQuMDYxeiAgICBNNDMuNTIzLDgxLjI2MWMxLjItMy4xLDIuNC02LjEsMy43LTkuOGM3OC45LDE0MiwyMzYuOCwyNTIuMSwzODguNiwzMDEuMWMxLjgwMSwwLjYsMy4xMDEsMC42LDQuMzAxLDAuNmMwLDEuMiwwLDIuNCwwLDMuNyAgIEMyNzEuNzIzLDM1Ny44NjEsMTIxLjgyMywyMjYuMzYxLDQzLjUyMyw4MS4yNjF6IiBmaWxsPSIjODcyNTIwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==';

    /**
     * Title for Tracy panel.
     * @var string
     */
    public static $title = 'Queries logger';


    /**
     * Whether to show or not '--keep-cache' in your queries.
     * @var boolean
     */
    public static $showKeepCache = false;

    /**
     * Logged queries
     * @var array
     */
    protected $queries;

    /**
     * Logger must implement RedBean's Logger interface.
     * @var \RedBeanPHP\Logger
     */
    protected $logger;

    /**
     * Helper method to collect the queries and show the panel.
     * @param  RedBeanBarPanel $panel [description]
     */
    public static function boot(RedBeanBarPanel $panel)
    {
        $panel->collect();
        Debugger::getBar()->addPanel($panel);
    }

    /**
     * Set RedBean's logger
     * @param \RedBeanPHP\Logger $logger
     */
    public function __construct(\RedBeanPHP\Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Collect all the executed queries by now.
     */
    protected function collect()
    {
        $logger = $this->logger;

        $output = $logger->grep(' ');

        $queries = [];

        foreach ($output as $key => $value) {
            // Clean all "resultsets" outputs
            if (substr($value, 0, 9) == 'resultset') {
                unset($output[$key]);
            } else {
                if (self::$showKeepCache) {
                    $queries[] = $value;
                } else {
                    $queries[] = str_replace('-- keep-cache', '', $value);
                }
            }
        }

        $this->queries = $queries;
    }

    /**
	 * Renders HTML code for custom tab.
	 * @return string
	 */
    public function getTab()
    {
        $html = '<img src="'.self::$icon.'" alt="RedBeanPHP queries logger for Tracy"/> ';
        $queries = count($this->queries);
        if ($queries == 1) {
            $html .= '1 query';
        } else {
            $html .= $queries.' queries';
        }
        return $html;
    }

    /**
	 * Renders HTML code for custom panel.
	 * @return string
	 */
    public function getPanel()
    {
        $queries = $this->queries;
        $html = '<h1>'.self::$title.'</h1>';
        $html .= '<div class="tracy-inner tracy-InfoPanel"><table width="300">';
        \SqlFormatter::$pre_attributes = 'style="color: black;"';
        foreach ($queries as $query) {
            $html .= '<tr><td>'.\SqlFormatter::highlight($query).'</td></tr>';
        }
        $html .= '</table></div>';

        return $html;
    }
}
