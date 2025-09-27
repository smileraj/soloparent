<?php
declare(strict_types=1);

class JLView
{
    /**
     * Display messages
     *
     * @param array $messages
     * @param bool  $admin
     */
    public function messages(array &$messages, bool $admin = true): void
    {
        if (empty($messages)) {
            return;
        }

        $stringMessages = '';
        $className      = 'warning';
        $validMessage   = 0;
        $errorMessage   = 0;

        // Build messages and detect type
        foreach ($messages as $message) {
            $stringMessages .= $message;
            if (str_contains($message, '"valid"')) {
                $validMessage++;
            } elseif (str_contains($message, '"error"')) {
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
        <div class="messages <?= htmlspecialchars($className, ENT_QUOTES, 'UTF-8'); ?>">
            <?= $stringMessages /* escaped earlier if needed */ ?>
        </div>
        <?php
        // Close panel for admin
        if ($admin && class_exists('JLPanel')) {
            JLPanel::close();
        }
    }
}
