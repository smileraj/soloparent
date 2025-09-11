<?php

class JLView
{
    public function __construct()
    {
        // Nothing special on init
    }

    /**
     * Display messages
     *
     * @param array $messages
     * @param bool  $admin
     */
    public function messages(array &$messages, bool $admin = true): void
    {
        if (!count($messages)) {
            return;
        }

        $stringMessages = '';
        $className      = 'warning';
        $validMessage   = 0;
        $errorMessage   = 0;

        // Build messages and detect type
        foreach ($messages as $message) {
            $stringMessages .= $message;
            if (preg_match('/"valid"/', $message)) {
                $validMessage++;
            } elseif (preg_match('/"error"/', $message)) {
                $errorMessage++;
            }
        }

        // Determine CSS class
        if ($validMessage && !$errorMessage) {
            $className = 'valid';
        }

        // Open panel for admin
        if ($admin && class_exists('JLPanel')) {
            JLPanel::open();
        }

        ?>
        <div class="messages <?php echo htmlspecialchars($className, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo $stringMessages; ?>
        </div>
        <?php

        // Close panel for admin
        if ($admin && class_exists('JLPanel')) {
            JLPanel::close();
        }
    }
}
