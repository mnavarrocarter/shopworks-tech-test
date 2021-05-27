### 1. How long did you spend on the coding test? What would you add to your solution if you had more time?

I think overall I spent around 5 hours divided in two evenings. I would
probably add the ability to take lunch breaks into account for the
single manning calculation.

### 2. Why did you choose PHP as your main programming language?

It's easy to prototype and therefore very productive from the ground up. Plus
it's improved support on typing allows me to be more confident that my code
works as intended with less testing.

### 3. What is your favourite thing about your most familar PHP framework (Laravel / Symfony etc)? 

I love that Symfony does not trump quality in favor of developer experience
like other frameworks out there. It does not attempt to make things
easier for you (somehow assuming that you are incapable of learning), but
rather empowers you to make choices, and wire some stuff yourself. That
teaches you, makes you grow as developer. That and the Profiler, which is
the most amazing debug tool has ever been written in PHP.

### 4. What is your least favourite thing about the above framework? 

Probably the Request/Response abstractions in HTTP Foundation: they need a lot
of rethinking and rework. Some components were written ages ago and are
due to refactors with more modern design, like Security or Console. And
the Messenger component is really complicated and cumbersome when the only
thing you need is a simple command bus.