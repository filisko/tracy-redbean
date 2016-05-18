<?php
namespace Filisko\Tracy;

class RedBeanBarPanel implements \Tracy\IBarPanel
{
    // http://www.flaticon.com/free-icon/coffee-bean_63156
    public $icon = 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDUwMS43NTIgNTAxLjc1MiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTAxLjc1MiA1MDEuNzUyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTQ0MC43MjMsMTg0LjA2MWMtODguMS05NC45LTI2NS42LTE3Mi0zOTYuNi0xNDQuNGMtOC42LDEuOC0xMi4yLDguNi0xMSwxNS4zYy04MS40LDQ0LjcsOC42LDE5OS41LDQyLjgsMjQ0LjggICBjNjcuMyw5MCwxODcuODk5LDE5MC44OTksMzA5LjEsMTYzLjM5OWM1NS43LTEyLjg5OSw5Ni43LTY1LjUsMTEyLTExOC4xQzUxNC43MjMsMjg1LjA2MSw0NzkuODIzLDIyNi4zNjEsNDQwLjcyMywxODQuMDYxeiAgICBNNDMuNTIzLDgxLjI2MWMxLjItMy4xLDIuNC02LjEsMy43LTkuOGM3OC45LDE0MiwyMzYuOCwyNTIuMSwzODguNiwzMDEuMWMxLjgwMSwwLjYsMy4xMDEsMC42LDQuMzAxLDAuNmMwLDEuMiwwLDIuNCwwLDMuNyAgIEMyNzEuNzIzLDM1Ny44NjEsMTIxLjgyMywyMjYuMzYxLDQzLjUyMyw4MS4yNjF6IiBmaWxsPSIjODcyNTIwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==';
    public $title = 'Queries logger';
    public $styles = 'color:#333';
    private $queries;

    public function __construct($logger, $keep_cache = false, $icon = null, $title = null, $styles = null)
    {
        $queries = [];
        if ($logger)
        {
            $output = $logger->grep(' ');
            foreach ($output as $key => $value)
            {
                // Clean all "resultsets" outputs
                if (substr($value, 0, 9) == 'resultset')
                {
                    unset($output[$key]);
                }
                else
                {
                    // Leave or not keep_cache
                    if ($keep_cache)
                    {
                        $queries[] = $value;
                    }
                    else
                    {
                        $queries[] = str_replace('-- keep-cache', '', $value);
                    }
                }
            }
        }
        $this->queries = $queries;

        // Custom base64 encoded icon
        if ($icon) {
            $this->icon = $icon;
        }

        // Custom title
        if ($title) {
            $this->title = $title;
        }

        // Custom styles for queries
        if ($styles) {
            $this->styles = $styles;
        }
    }

    public function getTab()
    {
        $title = '<img src="'.$this->icon.'" /> ';
        $queries = count($this->queries);
        if ($queries == 1) {
            $title .= '1 query';
        } else {
            $title .= $queries . ' queries';
        }
        return $title;
    }

    public function getPanel()
    {
        $queries = $this->queries;
        $html = '<h1>'.$this->title.'</h1>';
        $html .= '<div class="tracy-inner tracy-InfoPanel"><table>';
        foreach ($queries as $query) {
            $html .= '<tr><td><pre style="'.$this->styles.'">'. $query . '</pre></td></tr>';
        }
        $html .= '</table></div>';

        return $html;
    }
}
