######################################
# Section: FLOW Command from subdir
######################################
#
# Implementation of a FLOW command which can be executed inside
# sub directories of the FLOW distribution; just finds the base
# distribution directory and calls the appropriate FLOW command
#
flow() {
  local startDirectory=`pwd`
  cd "$FLOW_ROOTPATH"
  ./flow $@
  cd "$startDirectory"
}
