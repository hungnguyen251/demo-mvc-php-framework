<?php

class Template
{
    private $__content = null;
    public function run($content, $data=[]) {
        if (!empty($data)) {
            extract($data);
        }

        if (!empty($content)) {
            $this->__content = $content;

            $this->printEntities();
    
            $this->printRaw();
    
            $this->condition();

            $this->beginPhp();

            $this->endPhp();

            $this->forLoop();

            $this->whileLoop();

            $this->foreachLoop();

            eval('?> '.$this->__content.' <?php ');
        }
    }

    /**
     * Xử lí dữ liệu $data từ controller TH vói htmlentities {{$data}}
     * htmlemtities Chuyển đổi tất cả các ký tự áp dụng thành các thực thể HTML
     */
    public function printEntities() {
        preg_match_all('~{{\s*(.+?)\s*}}~is', $this->__content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php echo htmlentities('.$value.');?>', $this->__content);
            }
        }
    }

    /**
     * Xử lí dữ liệu $data từ controller TH {! $data !} và non htmlentities
     */
    public function printRaw() {
        preg_match_all('~{!\s*(.+?)\s*!}~is', $this->__content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php echo '.$value.';?>', $this->__content);
            }
        }  
    }

    /**
     * Xử lí câu điều kiện if else
     */
    public function condition() {
        //Xử lý if (@if (condition))
        preg_match_all('~@if\s*\((.+?)\s*\)\s*$~im', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php if ('.$value.'): ?>', $this->__content);
            }
        }  

        //Xử lý else (@else)
        preg_match_all('~@else\s*$~im', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php else: ?>', $this->__content);
            }
        }  

        //Xử lí endif (@endif)
        preg_match_all('~@endif\s*$~im', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php endif; ?>', $this->__content);
            }
        } 
    }

        
    /**
     * Xử lí @php <=> <?php
     */
    public function beginPhp() {
        preg_match_all('~@php~is', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php ', $this->__content);
            }
        } 
    }

    /**
     * Xử lí @endphp <=> ?>
     */
    public function endPhp() {
        preg_match_all('~@endphp~is', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], ' ?>', $this->__content);
            }
        } 
    }

    /**
     * Xử lí vòng lặp for => @for, @endfor
     */
    public function forLoop() {
        preg_match_all('~@for\s*\((.+?)\s*\)\s*$~im', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php for ('.$value.'): ?>', $this->__content);
            }
        } 

        //Xử lí endfor (@endfor)
        preg_match_all('~@endfor\s*$~im', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php endfor; ?>', $this->__content);
            }
        } 
    }

    /**
     * Xử lí vòng lặp while => @while, @endwhile
     */
    public function whileLoop() {
        preg_match_all('~@while\s*\((.+?)\s*\)\s*$~im', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php while ('.$value.'): ?>', $this->__content);
            }
        } 

        //Xử lí endfor (@endfor)
        preg_match_all('~@endwhile\s*$~im', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php endwhile; ?>', $this->__content);
            }
        } 
    }

    /**
     * Xử lí vòng lặp foreach => @foreach, @endforeach
     */
    public function foreachLoop() {
        preg_match_all('~@foreach\s*\((.+?)\s*\)\s*$~im', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php foreach ('.$value.'): ?>', $this->__content);
            }
        } 

        //Xử lí endfor (@endfor)
        preg_match_all('~@endforeach\s*$~im', $this->__content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key=>$value) {
                $this->__content = str_replace($matches[0][$key], '<?php endforeach; ?>', $this->__content);
            }
        } 
    }
}