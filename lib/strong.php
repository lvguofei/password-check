<?php
$arr1 = array(0,1,2,3,4,5,6,7,8,9);
$arr2 = array(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z);
$arr3 = array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
$arr4 = array('!','@','#','$','%','^','&','*',);
// 在 $chars 中随机取 $length 个数组元素键名
//$keys = array_rand($chars, $length);
$key1 = array_rand($arr1, 1);
$key2 = array_rand($arr2, 1);
$key3 = array_rand($arr3, 1);
$key4 = array_rand($arr4, 1);
$key5 = array_rand($arr2, 1);
$key6 = array_rand($arr2, 1);
$key7 = array_rand($arr3, 1);
$key8 = array_rand($arr1, 1);
$arr = array();
array_push($arr,$arr2[$key2],$arr3[$key3],$arr1[$key1],$arr4[$key4],$arr2[$key5],$arr2[$key6],$arr3[$key7],$arr1[$key8]);
$password = implode($arr);
echo $password;

function make_password( $length  )
{
    // 密码字符集，可任意添加你需要的字符
    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!',
        '@','#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
        '[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
        '.', ';', ':', '/', '?', '|');
    // 在 $chars 中随机取 $length 个数组元素键名
    //$keys = array_rand($chars, $length);
    for($i = 0; $i < $length; $i++)
    {
        // 将 $length 个数组元素连接成字符串
        $password .= ','.$chars[$keys[$i]];
    }
    $str = '!,@,#,$,%,^,&,*,(,),_,+,-,=';
    $str1 = explode(',',$str);
    $str2 = explode(',',$password);
    //var_dump($str1);
   // var_dump($str2);
    $intersection = array_intersect($str1, $str2);
    $cou = count($intersection);
    //print_r($intersection);
    //print_r($cou);
    if($cou >= 3){
        return make_password( 10);
    }
    $password = implode($str2);
    return $password;
}
//echo make_password( 10);

