<?php
    class ImgData 
    {
        private $img;
        private $img_name;
        private $height;
        private $width;
        private $yPos;
        function __construct($img,$img_name, $height, $width, $yPos) {
            $this->img = $img;
            $this->img_name = $img_name;
            $this->height = $height;
            $this->width = $width;
            $this->yPos = $yPos;
        }

        public function getImg(){
            return $this->img;
        }
        public function getImage_name(){
            return $this->img_name;
        }
        public function getHeight(){
            return $this->height;
        }
        public function getWidth(){
            return $this->width;
        }
        public function getYPos(){
            return $this->yPos;
        }
    }

    function my_merge_image($images, $output_name, $padding = 0){
        $img_hauteur = 0;
        $tabl_result = [];
        $tabl_width = [];
        //Merge the images into one.
        if(!empty($images)){
            foreach ($images as $index => $image) {
               
                list($width, $height, $type, $size) = getimagesize($image);
                if(stristr($image, '.png')){
                    $imgData = new ImgData(imagecreatefrompng($image),"sprite-".$index ,$height, $width, $img_hauteur + $padding);
                } elseif(stristr($image, '.jpg') || stristr($image, '.jpeg')){
                    $imgData = new ImgData(imagecreatefromjpeg($image),"sprite-".$index ,$height, $width, $img_hauteur + $padding);
                } 
                elseif(stristr($image, '.gif')){
                    $imgData = new ImgData(imagecreatefromgif($image),"sprite-".$index ,$height, $width, $img_hauteur + $padding);
                }
                $img_hauteur += $height += $padding;
                array_push($tabl_result, $imgData);
                array_push($tabl_width, $width);
            }            
            $width_max = max($tabl_width);
            $image_final = imagecreatetruecolor($width_max, $img_hauteur);

            foreach ($tabl_result as $elem) {
                imagecopy($image_final, $elem->getImg(), 0, $elem->getYPos(), 0, 0, $width_max, $elem->getHeight());
            }
            imagepng($image_final, $output_name . ".png");
        }
    }

    function my_generate_css($img_url, $css_name = "style.css"){

        //Generates a css file that displays the result of the image merge.
        $content = "body{\n\tbackground-image: url($img_url.png);\n\tbackground-repeat: no-repeat;\n\tdisplay: block;\n}\n";
        file_put_contents($css_name, $content);
    }
    
    function my_scandir($recursive_activated, $assets_folder){
    
        $tabl_path = [];
        //Browse through folders and get each image path.
        if(is_dir($assets_folder)){
            $pointeur = opendir($assets_folder);
            $pattern = '/\.(jpg|png|jpeg|gif)$/';
            while ($fichier = readdir($pointeur)) {

                if($fichier != '.' && $fichier != '..' && $fichier != '.git'){
                    if(is_dir($assets_folder.$fichier)  && $recursive_activated){
                        //Folder
                        $tabl_path = array_merge($tabl_path, my_scandir(true, $assets_folder.$fichier."/"));
                    } else {
                        //Image
                        if(preg_match($pattern, $fichier)){
                            array_push($tabl_path, $assets_folder.$fichier);
                        }
                    }
                }
                

            }
            closedir($pointeur);
            return $tabl_path;

        }
        else{
            echo "$assets_folder is not a directory\n";
            return $tabl_path;
        }
    }

    function main(){
        
        //Retrieves all the information necessary for the execution of the program
        $options = $_SERVER['argv'];
        $recursive_activated = in_array('-r', $options) || in_array('--recursive', $options);
        $tab_images_path = my_scandir($recursive_activated, end($options));
        $output_name = "sprite";
        
        if(in_array('-i', $options)){
            $index = array_search('-i', $options) + 1;
            $output_name = $options[$index];
            if(in_array('-p', $options)){
                $index = array_search('-p', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            } elseif(in_array('--padding', $options)){
                $index = array_search('--padding', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            } else {
                my_merge_image($tab_images_path, $output_name);
            }
        } elseif(in_array('--output-image', $options)){
            $index = array_search('--output-image', $options) + 1;
            $output_name = $options[$index];
            if(in_array('-p', $options)){
                $index = array_search('-p', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            } elseif(in_array('--padding', $options)){
                $index = array_search('--padding', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            }else {
                my_merge_image($tab_images_path, $output_name);
            }
        } else {
            if(in_array('-p', $options)){
                $index = array_search('-p', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            } elseif(in_array('--padding', $options)){
                $index = array_search('--padding', $options) + 1;
                $padding = $options[$index];
                my_merge_image($tab_images_path, $output_name, $padding);
            } else {
                my_merge_image($tab_images_path, $output_name);
            }
            
        }

        

        $img_url = './'.$output_name;
        if(in_array('-s', $options)){
            $index = array_search('-s', $options) + 1;
            $output_style = $options[$index];
            my_generate_css($img_url, $output_style . ".css");
        } elseif(in_array('--output-style', $options)){
            $index = array_search('--output-style', $options) + 1;
            $output_style = $options[$index];
            my_generate_css($img_url, $output_style . ".css");
        } else {
            my_generate_css($img_url);
        }

    }
    main();
    
?>