public function up() {
        Schema::create('students', function(Blueprint $table) {
                $table->id();
                $table->string('nia')->unique();
                $table->string('dni')->unique();
                $table->string('name');
                $table->string('phone');
                $table->string('location');
                $table->string('email')->unique();
                $table->timestamps();
        });
