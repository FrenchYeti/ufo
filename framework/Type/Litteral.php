<?php
 
namespace Ufo\Type;

class Litteral extends TypeAbstract
{
    static public $Flags = array(
        'carrier_ret'=>'\r\n',
        'tabs'=>'\t',
        'punctuated'=>'\x{2E}\x{B3}\x{c2}\x{21}\x{3f}\x{3a}\x{27}\x{22}'
    );

    
    static public $utf8_fr_low = array(
        "\x{00E0}","\x{00E2}","\x{00E4}",
        "\x{00E7}","\x{00E8}","\x{00E9}","\x{00EA}",
        "\x{00EB}","\x{00EE}","\x{00EF}","\x{00F4}",
        "\x{00F6}","\x{00FB}","\x{00FC}"
    );
    
    static public $utf8_fr_up = array(
        "\x{00C0}","\x{00C2}","\x{00C4}",
        "\x{00C7}","\x{00C8}","\x{00C9}","\x{00CA}",
        "\x{00CB}","\x{00CE}","\x{00CF}","\x{00D4}",
        "\x{00D6}","\x{00DB}","\x{00DC}"
    );
    
    static public $Pattern = '\p{L}\p{N}
        \x{00C0}\x{00C2}\x{00C4}
        \x{00C7}\x{00C8}\x{00C9}\x{00CA}
        \x{00CB}\x{00CE}\x{00CF}\x{00D4}
        \x{00D6}\x{00DB}\x{00DC}
        \x{00E0}\x{00E2}\x{00E4}
        \x{00E7}\x{00E8}\x{00E9}\x{00EA}
        \x{00EB}\x{00EE}\x{00EF}\x{00F4}
        \x{00F6}\x{00FB}\x{00FC}';
}