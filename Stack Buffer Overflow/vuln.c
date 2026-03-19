//This file (obviously) is completely vulnerable to stack buffer overflow attacks
//Compile it with GNU compiler as follows: gcc -m32 -o vuln vuln.c -z execstack -fno-stack-protector

#include <stdio.h>
#include <string.h>

int main (int argc, char** argv)
{
        char buffer[256];
        strcpy(buffer, argv[1]);

        return 0;
}
