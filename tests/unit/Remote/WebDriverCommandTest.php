<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Facebook\WebDriver\Remote;

use Facebook\WebDriver\Exception\WebDriverException;
use PHPUnit\Framework\TestCase;

class WebDriverCommandTest extends TestCase
{
    public function testShouldSetOptionsUsingConstructor()
    {
        $command = new WebDriverCommand('session-id-123', 'bar-baz-name', ['foo' => 'bar']);

        $this->assertSame('session-id-123', $command->getSessionID());
        $this->assertSame('bar-baz-name', $command->getName());
        $this->assertSame(['foo' => 'bar'], $command->getParameters());
    }

    public function testCustomCommandInit()
    {
        $command = new WebDriverCommand('session-id-123', 'customCommand', ['foo' => 'bar']);
        $command->setCustomRequestParameters('/some-url', 'POST');

        $this->assertSame('/some-url', $command->getCustomUrl());
        $this->assertSame('POST', $command->getCustomMethod());
    }

    public function testCustomCommandInvalidUrlExceptionInit()
    {
        $this->expectException(WebDriverException::class);
        $command = new WebDriverCommand('session-id-123', 'customCommand', ['foo' => 'bar']);
        $command->setCustomRequestParameters('url-without-leading-slash', 'POST');
    }

    public function testCustomCommandInvalidMethodExceptionInit()
    {
        $this->expectException(WebDriverException::class);
        $command = new WebDriverCommand('session-id-123', 'customCommand', ['foo' => 'bar']);
        $command->setCustomRequestParameters('/some-url', 'invalid-method');
    }
}
