<?php
namespace UON\BashComplete\Command;

/*                                                                        *
 * This script belongs to the FLOW3 package "UON.BashComplete".           *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Bash command controller for the UON.BashComplete package
 *
 * @FLOW3\Scope("singleton")
 */
class BashCommandController extends \TYPO3\FLOW3\Cli\CommandController {

	/**
	 * @var \TYPO3\FLOW3\Package\PackageManagerInterface
	 * @FLOW3\Inject
	 */
	protected $packageManager;

	/**
	 * @var \TYPO3\FLOW3\Core\Bootstrap
	 * @FLOW3\Inject
	 */
	protected $bootstrap;

	/**
	 * @var \TYPO3\FLOW3\Cli\CommandManager
	 * @FLOW3\Inject
	 */
	protected $commandManager;

	/**
	 * Compiles flow3 cli to enable command completion
	 *
	 * @param bool $verbose
	 * @return void
	 */
	public function compileCommand($verbose = true) {
		$this->outputLine('Start analyzing the enabled CLI commands');
		$commands = $this->commandManager->getAvailableCommands();
		$commandsByPackagesAndControllers = $this->buildCommandsIndex($commands);

		$commandList = array();
		$output = '';

		foreach ($commandsByPackagesAndControllers as $packageKey => $commandControllers) {
			foreach ($commandControllers as $commands) {
				foreach ($commands as $command) {
					$commandIdentifier = $this->commandManager->getShortestIdentifierForCommand($command);

					$commandList[] = $commandIdentifier;

					$arguments = array();

					$matchingCommands = $this->commandManager->getCommandsByIdentifier($commandIdentifier);
					$matchingCommand = array_shift($matchingCommands);
					if ($matchingCommand instanceof \TYPO3\FLOW3\Cli\Command) {
						$commandArgumentDefinitions = $matchingCommand->getArgumentDefinitions();

						if ($command->hasArguments()) {
							foreach ($commandArgumentDefinitions as $commandArgumentDefinition) {
								$arguments[] = $commandArgumentDefinition->getDashedName();
							}
						}
					}

					$output .= vsprintf("%s;\t%s\n", array($commandIdentifier, join(' ', $arguments)));
				}

			}
		}

		$output = vsprintf("%s\t%s\n%s", array('COMMANDS', join(' ', $commandList), $output));
		if ($verbose === false) {
			$this->outputLine($output);
		}

		file_put_contents(getenv('HOME') . '/.flow3_complete', $output);
		$this->outputLine('Wrote ~/.flow3_complete');

	}

	/**
	 * Builds an index of available commands. For each of them a Command object is
	 * added to the commands array of this class.
	 *
	 * @param array<\TYPO3\FLOW3\Cli\Command> $commands
	 * @return array in the format array('<packageKey>' => array('<CommandControllerClassName>', array('<command1>' => $command1, '<command2>' => $command2)))
	 */
	protected function buildCommandsIndex(array $commands) {
		$commandsByPackagesAndControllers = array();
		foreach ($commands as $command) {
			if ($command->isInternal()) {
				continue;
			}
			$commandIdentifier = $command->getCommandIdentifier();
			$packageKey = strstr($commandIdentifier, ':', TRUE);
			$commandControllerClassName = $command->getControllerClassName();
			$commandName = $command->getControllerCommandName();
			$commandsByPackagesAndControllers[$packageKey][$commandControllerClassName][$commandName] = $command;
		}
		return $commandsByPackagesAndControllers;
	}
}

?>