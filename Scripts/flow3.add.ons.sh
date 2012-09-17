######################################
# Section: FLOW3 Command from subdir
######################################
#
# Implementation of a FLOW3 command which can be executed inside
# sub directories of the FLOW3 distribution; just finds the base
# distribution directory and calls the appropriate FLOW3 command
#
flow3() {
  local startDirectory=`pwd`
  cd "$FLOW3_ROOTPATH"
  ./flow3 $@
  cd "$startDirectory"
}
