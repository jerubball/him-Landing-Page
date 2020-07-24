#alias cp='cp -i'
#alias mv='mv -i'
#alias rm='rm -i'

#alias ls='ls --color=auto'
#alias dir='dir --color=auto'
#alias vdir='vdir --color=auto'
#alias grep='grep --color=auto'
#alias fgrep='fgrep --color=auto'
#alias egrep='egrep --color=auto'

#alias ll='ls -alF'
#alias la='ls -A'
#alias l='ls -CF'


#function cd..() {
#    cd ..
#}

alias cd..='cd ..'
alias cd~='cd ~'
alias cdhome='cd ~'
alias cdh='cd ~'
#alias cd/='cd /'
alias cdroot='cd /'
alias cdr='cd /'

alias chdir='cd'
alias chdir..='cd ..'
alias chdir~='cd ~'

alias md='mkdir'
alias rd='rmdir'

alias sus='sudo -Es'
alias sudos='sudo -s'
alias sudoi='sudo -i'

#alias nano='nano -ASZcilm$ -T4'
alias nanos='/bin/nano -ASZcilm -T4 -$'

if [ $EUID != 0 ]; then
	alias him-update-site='pushd ~/Documents/Git/him-Landing-Page/bin; ./update.sh; popd'
	alias him-get='~/bin/him-get.sh'
	alias compile='~/bin/compile.sh'
fi

if [ $EUID != 0 ]; then
	alias shutdown='sudo shutdown'
	#alias apt='sudo apt'
fi
alias restart='shutdown -r'

if [ $EUID != 0 ]; then
	alias apt-update='sudo apt update -y; sudo apt upgrade -y'
	alias apt-upgrade='sudo apt update -y; sudo apt full-upgrade --fix-missing -y; sudo apt autoremove -y; sudo apt autoclean -y'
else
	alias apt-update='apt update -y; apt upgrade -y'
	alias apt-upgrade='apt update -y; apt full-upgrade --fix-missing -y; apt autoremove -y; apt autoclean -y'
fi

function pd {
	if [ $# == 0 ]; then
		popd
	else
		while [ $# != 0 ]; do
			pushd $1
			shift
		done
	fi
}

if [ -f ~/.selected_editor ]; then
	. ~/.selected_editor
else
	SELECTED_EDITOR="/bin/nano"
fi

EDITOR='nano'
SUDO_EDITOR='nano'
