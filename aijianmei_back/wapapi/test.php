<?php
class A {    
   public function x() {        
      echo "A::x() was called.\n";    
   }    
   public function y() {        
      self::x();        
      echo "A::y() was called.\n";    
   }    
   public function z() {        
      $this->x();        
      echo "A::z() was called.\n";    
   }
}
class B extends A {    
   public function x() {        
      echo "B::x() was called.\n";    
   }
}

$b = new B();
$b->y();
echo "--\n";
$b->z();