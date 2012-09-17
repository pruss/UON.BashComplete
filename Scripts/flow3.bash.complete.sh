export COMP_WORDBREAKS="${COMP_WORDBREAKS//:/}"

flow3compile()
{
	local startDirectory=`pwd`
	cd "$FLOW3_ROOTPATH"
	./flow3 bash:compile
	cd "$startDirectory"
}

_flow3()
{
	local first cur opts

	COMPREPLY=()

	cur="${COMP_WORDS[COMP_CWORD]}"

	if [ ${COMP_CWORD} -eq 1 ]; then
		opts=`grep -- "^COMMANDS"  ~/.flow3_complete|cut -f2`
	else
		first="${COMP_WORDS[1]}"

		if [ $first = "help" ]; then
			opts=`grep -- "^COMMANDS"  ~/.flow3_complete|cut -f2`
		else
			opts=`grep -- "^${first};"  ~/.flow3_complete|cut -f2`
		fi
	fi

    COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
    return 0

}
complete -o default -F _flow3 flow3
