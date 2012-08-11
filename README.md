UON.BashComplete
================

Bash compeletion for TYPO3 FLOW3

add this to your .bashrc
#<----copy start---->
>export FLOW3_ROOTPATH=<Path/To/Your/FLOW3/>
>
>source $FLOW3_ROOTPATH/Packages/Application/UON.BashComplete/Scripts/flow3.add.ons.sh
>source $FLOW3_ROOTPATH/Packages/Application/UON.BashComplete/Scripts/flow3.bash.complete.sh
#<----copy end  ---->

To activate you new bash settings run
>source ~/.bashrc

Description
flow3.add.ons.sh
----------------
With this you can use
>flow3
instead of
>./flow3


flow3.bash.complete.sh
----------------------
Provides bash code completion.

Before using the first time run
>flow3compile

