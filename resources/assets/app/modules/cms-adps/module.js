//import {bundleVersionSelect} from "./handlers/bundleVersionSelect";
import {showArchive} from "./handlers/showArchive";
import {hideArchive} from "./handlers/hideArchive";
import {hideTasks} from "./handlers/hideTasks";
import {showTasks} from "./handlers/showTasks";
import {copyAdp} from "./handlers/copyAdp";
import {copyAssets} from "./handlers/copyAssets";

import './styles.scss';

$(document)
    /**
     * Show archive adp categories
     */
    .on('click', '.show-archive', showArchive)
    /**
     * Hide archive adp categories
     */
    .on('click', '.hide-archive', hideArchive)
    /**
     * Hide adp tasks by status and user
     */
    .on('click', '.hide-tasks', hideTasks)
    /**
     * Show adp tasks by status and user
     */
    .on('click', '.show-tasks', showTasks)
    /**
     * Show adp tasks by status and user
     */
    .on('click', '.copy-adp', copyAdp)
    /**
     * Show adp tasks by status and user
     */
    .on('click', '.copy-assets', copyAssets);
    