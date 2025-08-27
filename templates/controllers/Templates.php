<?php
class Templates extends Trongate
{

    function pharmacy($data)
    {

        $paths = [];
        
        if (isset($data['view_fragments'])) {
            if (is_array($data['view_fragments'])) {
                foreach ($data['view_fragments'] as $fragment) {
                    array_push($paths, $this->_get_view_path($fragment, $data['view_module']));
                }
            }

            if (is_string($data['view_fragments'])) {
                array_push($paths, $this->_get_view_path($data['view_fragments'], $data['view_module']));

            }

        }

        $data['view_fragment_paths'] = $paths;


        load('pharmacy', $data);
    }

    function pos($data)
    {
        $paths = [];
        if (isset($data['view_fragments'])) {
            if (is_array($data['view_fragments'])) {
                foreach ($data['view_fragments'] as $fragment) {
                    array_push($paths, $this->_get_view_path($fragment, $data['view_module']));
                }
            }

            if (is_string($data['view_fragments'])) {
                array_push($paths, $this->_get_view_path($data['view_fragments'], $data['view_module']));

            }

        }

        $data['view_fragment_paths'] = $paths;


        load('pos', $data);
    }

    function dashboard($data)
    {
        $paths = [];
        if (isset($data['view_fragments'])) {
            if (is_array($data['view_fragments'])) {
                foreach ($data['view_fragments'] as $fragment) {
                    array_push($paths, $this->_get_view_path($fragment, $data['view_module']));
                }
            }

            if (is_string($data['view_fragments'])) {
                array_push($paths, $this->_get_view_path($data['view_fragments'], $data['view_module']));

            }

        }

        $data['view_fragment_paths'] = $paths;

        load('dashboard', $data);

    }

    function login($data)
    {
        load('login', $data);
    }

    function public($data)
    {
        if (isset($data['additional_includes_top'])) {
            $data['additional_includes_top'] = $this->_build_additional_includes($data['additional_includes_top']);
        } else {
            $data['additional_includes_top'] = '';
        }

        if (isset($data['additional_includes_btm'])) {
            $data['additional_includes_btm'] = $this->_build_additional_includes($data['additional_includes_btm']);
        } else {
            $data['additional_includes_btm'] = '';
        }


        load('public', $data);
    }

    function error_404($data)
    {
        load('error_404', $data);
    }

    function admin($data)
    {
        load('admin', $data);
    }

    function _build_css_include_code($file)
    {
        $code = '<link rel="stylesheet" href="' . $file . '">';
        $code = str_replace('""></script>', '"></script>', $code);
        return $code;
    }

    function _build_js_include_code($file)
    {
        $code = '<script src="' . $file . '"></script>';
        $code = str_replace('""></script>', '"></script>', $code);
        return $code;
    }

    function _build_additional_includes($files)
    {

        $html = '';
        foreach ($files as $file) {
            $file_bits = explode('.', $file);
            $filename_extension = $file_bits[count($file_bits) - 1];

            if (($filename_extension !== 'js') && ($filename_extension !== 'css')) {
                $html .= $file;
            } else {
                if ($filename_extension == 'js') {
                    $html .= $this->_build_js_include_code($file);
                } else {
                    $html .= $this->_build_css_include_code($file);
                }
            }

            $html .= '';
        }

        $html = trim($html);
        $html .= '';

        return $html;
    }
}
